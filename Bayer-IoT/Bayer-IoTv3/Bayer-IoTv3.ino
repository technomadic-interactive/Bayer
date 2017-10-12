#include <Wire.h>
#include "Adafruit_TMP007.h"
#include "Sodaq_RN2483.h"
#include "LIS3DE.h"
#include "RTCTimer.h"
#include "RTCZero.h"

#include "Sodaq_wdt.h"
#include "StringLiterals.h"
#include "Switchable_Device.h"
#include "Utils.h"

#define debugSerial SerialUSB
#define loraSerial Serial1
#define DEBUG
#define ENABLE_SLEEP
#define MAX_RTC_EPOCH_OFFSET 25

#define ADC_AREF 3.3f
//#define BATVOLT_R1 2.0f // One v1
//#define BATVOLT_R2 2.0f // One v1
#define BATVOLT_R1 4.7f // One v2
#define BATVOLT_R2 10.0f // One v2
#define BATVOLT_PIN BAT_VOLT

//The delay between sending data to server 
//#define READ_DELAY 3600000    // Send data every hour -- Sad cows
//#define READ_DELAY 14400000 // Send data every 4 hours -- Healthy Cows
#define READ_DELAY 10000
// ABP
const uint8_t devAddr[4] = { 0x00, 0x00, 0x00, 0x00 };
const uint8_t appSKey[16] = { 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00 };
const uint8_t nwkSKey[16] = { 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00, 0x00 };

// OTAA
/*
uint8_t DevEUI[8] = { 
  0x00, 0x04, 0xA3, 0x0B, 
  0x00, 0x1A, 0x5B, 0x19 
  };
*/
static uint8_t DevEUI[8];
uint8_t AppEUI[8] = {
  0xBE, 0x7E, 0x00, 0x00, 
  0x00, 0x00, 0x00, 0x5E 
  };
  

uint8_t AppKey[16] = {
  0x20, 0xF5, 0xDE, 0x35, 
  0x14, 0xB5, 0x7C, 0x61, 
  0x9F, 0x51, 0x15, 0x1D, 
  0x0B, 0x04, 0x45, 0x54
  };
// LEDS
int led6 = 6; // RED
int led7 = 7; // BLUE
int led8 =8; // GREEN
 
//TMP007
Adafruit_TMP007 tmp007;
String stringFloat;
float objt;
int avgTemp = 0;

// Battery Voltage
String stringVoltage;

// LIS3DE accelerometer & RTC Timer
//RTCZero rtc;
RTCTimer timer;
LIS3DE accelerometer;
double x, y, z;
int sumAcc = 0;
String xDouble, yDouble, zDouble;
volatile bool isOnTheMoveActivated;
volatile uint32_t lastOnTheMoveActivationTimestamp;
uint32_t getNow();
/*
 * 
 /*void initRtc();
void rtcAlarmHandler();
void resetRtcTimerEvents();
void initSleep();
*/
void accelerometerInt1Handler();
//volatile bool minuteFlag;
static bool isOnTheMoveInitialized;
void setAccelerometerTempSensorActive(bool on);


void setupLoRaOTAA(){
  if (LoRaBee.initOTA(loraSerial, DevEUI, AppEUI, AppKey, true))
  {
    #ifdef DEBUG
     debugSerial.println("Communication to LoRaBEE OTAA successful.");
    #endif    
  }
  else
  {
    #ifdef DEBUG
      debugSerial.println("OTAA Setup failed!");
    #endif
  }
}

void setup() {

  //Lìneas de prueba

  pinMode(led6, OUTPUT);
  pinMode(led7, OUTPUT);
  pinMode(led8, OUTPUT);
  digitalWrite(led6, HIGH);
  digitalWrite(led7, HIGH);
  digitalWrite(led8, HIGH);
  //Linea de prueba

  //Power up the LoRaBEE
  
  pinMode(ENABLE_PIN_IO, OUTPUT); // ONE
  digitalWrite(ENABLE_PIN_IO, HIGH); // ONE
  delay(3000);
  
  // Set GPS pin to LOW to conserve energy
  pinMode(GPS_ENABLE, OUTPUT);
  digitalWrite(GPS_ENABLE, LOW);
  #ifdef DEBUG
  while ((!SerialUSB) && (millis() < 10000)){
    // Wait 10 seconds for the Serial Monitor
  }
  
  //Set baud rate
  debugSerial.begin(57600);
  #else
 // consolePrintln("The USB is going to be disabled now.");
  SerialUSB.flush();
  sodaq_wdt_safe_delay(10000);
  SerialUSB.end();
  USBDevice.detach();
  USB->DEVICE.CTRLA.reg &= ~USB_CTRLA_ENABLE; // Disable USB
  #endif  

  loraSerial.begin(LoRaBee.getDefaultBaudRate());
  // Get HWEUI
  getHWEUI();
  
  // you can also use tmp007.begin(TMP007_CFG_1SAMPLE) or 2SAMPLE/4SAMPLE/8SAMPLE to have
  // lower precision, higher rate sampling. default is TMP007_CFG_16SAMPLE which takes
  // 60 seconds per reading (240 samples)
  if (! tmp007.begin()) {
    #ifdef DEBUG
      debugSerial.println("No sensor found");
    #endif
    while (1);
  }

  // Activate accelerometer
 isOnTheMoveInitialized = true;
  // Activate interrupt on the move
  initOnTheMove();
  
  // Debug output from LoRaBee
  // LoRaBee.setDiag(debugSerial); // optional
  
  //connect to the LoRa Network
  setupLoRa();

  // Setup timer events
  setupTimer();
  //Take first reading immediately
  takeReading(getNow());
  
}

void setupLoRa(){
  
  // ABP
  //setupLoRaABP();
  // OTAA
  setupLoRaOTAA();
}

bool sendPacket(String packet){
  switch (LoRaBee.sendReqAck(1, (uint8_t*)packet.c_str(), packet.length(), 8))
    {
    case NoError:
      #ifdef DEBUG
        debugSerial.println("Successful transmission.");
      #endif
      GREEN(); //Linea de prueba
      delay(100);
      digitalWrite(8,HIGH); //Linea de prueba
      return true;
      break;
    case NoResponse:
      #ifdef DEBUG
        debugSerial.println("There was no response from the device.");
      #endif
      setupLoRa();
      return false;
      break;
    case Timeout:
      #ifdef DEBUG
        debugSerial.println("Connection timed-out. Check your serial connection to the device! Sleeping for 20sec.");
      #endif
      delay(20000);
      return false;
      break;
    case PayloadSizeError:
      #ifdef DEBUG
        debugSerial.println("The size of the payload is greater than allowed. Transmission failed!");
      #endif
       setupLoRa();
       return false;
      break;
    case InternalError:
      #ifdef DEBUG
        debugSerial.println("Oh No! This shouldn't happen. Something is really wrong! Try restarting the device!\r\nThe network connection will reset.");
      #endif
      setupLoRa();
      return false;
      break;
    case Busy:
      #ifdef DEBUG
        debugSerial.println("The device is busy. Sleeping for 10 extra seconds.");
      #endif
      delay(10000);
      return false;
      break;
    case NetworkFatalError:
      #ifdef DEBUG
        debugSerial.println("There is a non-recoverable error with the network connection. You should re-connect.\r\nThe network connection will reset.");
      #endif
      setupLoRa();
      return false;
      break;
    case NotConnected:
      #ifdef DEBUG
        debugSerial.println("The device is not connected to the network. Please connect to the network before attempting to send data.\r\nThe network connection will reset.");
      #endif
      setupLoRa();
      return false;
      break;
    case NoAcknowledgment:
      #ifdef DEBUG
        debugSerial.println("There was no acknowledgment sent back!");
       #endif 
      // When you this message you are probaly out of range of the network.
       delay(1000);
       return false;
      break;
    default:
      return false;
      break;
    }
}

void getHWEUI()
{
//   setLoraActive(true);
 //  sodaq_wdt_safe_delay(10);
    if( LoRaBee.init(loraSerial,  0) ){
      #ifdef DEBUG
        debugSerial.println("HW reset enabled");
      #endif
    } else
    { 
      #ifdef DEBUG
        debugSerial.println("hwReset fail");
      #endif
      
    }
    uint8_t len = LoRaBee.getHWEUI(DevEUI, sizeof(DevEUI));
    
 //   setLoraActive(false); // make sure it is disabled in any case
}


/*
/**

 * Returns the board temperature.



int8_t getBoardTemperature()

{

    setAccelerometerTempSensorActive(true);




    int8_t temp = params.getTemperatureSensorOffset() + accelerometer.getTemperatureDelta();




    setAccelerometerTempSensorActive(false);




    return temp;

}
*/
/**

* Initializes the on-the-move functionality (interrupt on acceleration).

*/

void initOnTheMove()

{

    pinMode(ACCEL_INT1, INPUT);

    attachInterrupt(ACCEL_INT1, accelerometerInt1Handler, CHANGE);




    // Configure EIC to use GCLK1 which uses XOSC32K, XOSC32K is already running in standby

    // This has to be done after the first call to attachInterrupt()

    GCLK->CLKCTRL.reg = GCLK_CLKCTRL_ID(GCM_EIC) |

        GCLK_CLKCTRL_GEN_GCLK1 |

        GCLK_CLKCTRL_CLKEN;




    accelerometer.enable(true, LIS3DE::NormalLowPower10Hz, LIS3DE::XYZ, LIS3DE::Scale4g, true);

    sodaq_wdt_safe_delay(10);




    accelerometer.enableInterrupt1(

        LIS3DE::XHigh | LIS3DE::XLow | LIS3DE::YHigh | LIS3DE::YLow | LIS3DE::ZHigh | LIS3DE::ZLow,

        18.75 * 4.0 / 100.0,

        100,

        LIS3DE::MovementRecognition);

}

/**

 * Runs every time acceleration is over the limits

 * set by the user (if enabled).

*/

void accelerometerInt1Handler()

{

    if (digitalRead(ACCEL_INT1)) {

       




        // debugPrintln("On-the-move is triggered");




        isOnTheMoveActivated = true;

        lastOnTheMoveActivationTimestamp = getNow();

    }

}



/**

 * Initializes the accelerometer or puts it in power-down mode

 * for the purpose of reading its temperature delta.

*/

void setAccelerometerTempSensorActive(bool on)

{

    // if on-the-move is initialized then the accelerometer is enabled anyway

    if (isOnTheMoveInitialized) {

        return;

    }




    if (on) {

        accelerometer.enable(false, LIS3DE::NormalLowPower100Hz, LIS3DE::XYZ, LIS3DE::Scale2g, true);

        sodaq_wdt_safe_delay(30); // should be enough for initilization and 2 measurement periods

    }

    else {

        accelerometer.disable();

    }

}

/**
 * Returns the current datetime (seconds since unix epoch).
 */
uint32_t getNow()
{
      return millis();
}

void setupTimer()
{
   //Instruct the RTCTimer how to get the current time reading
  timer.setNowCallback(getNow);

   //Schedule the reading every second
  timer.every(READ_DELAY, takeReading);
}

void takeReading(uint32_t ts)
{
  //Wake Up LoRa
  sodaq_wdt_safe_delay(10);
  LoRaBee.wakeUp();
  // Measure body temperature
   objt = tmp007.readObjTempC();

  // Convert sensors data into strings
   xDouble = String(x,3);
   yDouble = String(y,3);
   zDouble = String(z,3);
   stringFloat = String(objt,3);
  
   #ifdef DEBUG
   debugSerial.print("Object Temperature: "); debugSerial.print(objt); debugSerial.println("*C");
   debugSerial.println(stringFloat);
   debugSerial.print("X: "); debugSerial.println(x);
   debugSerial.print("Y: "); debugSerial.println(y);
   debugSerial.print("Z: "); debugSerial.println(z);
   debugSerial.print("Voltaje: "); debugSerial.println(getBatteryVoltage());
   #endif
   
  // Tx data
  String packet = stringFloat + "," + xDouble + "," + yDouble + "," + zDouble + "," + getBatteryVoltage();
  // try until success Tx
  while (!sendPacket(packet)){
    #ifdef DEBUG
      debugSerial.println(" reconectar");
    #endif
    delay(10000);
    }
  x=y=z=0;
  LoRaBee.sleep();
}

// Battery Voltage
uint16_t getBatteryVoltage()
{
    return (uint16_t)((ADC_AREF / 1.023) * (BATVOLT_R1 + BATVOLT_R2) / BATVOLT_R2 * (float)analogRead(BATVOLT_PIN));

}
//---------------LOOP CODE----------------
void loop() {
  // Detect movement and increase axis
 
   x+=accelerometer.getX();
   y+=accelerometer.getY();
   z+=accelerometer.getZ();
   
   timer.update();

}
void RED() {
  digitalWrite(led6, LOW);
  digitalWrite(led7, HIGH);
  digitalWrite(led8, HIGH);
}

void GREEN() {

  digitalWrite(led6, HIGH);
  digitalWrite(led7, HIGH);
  digitalWrite(led8, LOW);
}

void BLUE() {
 digitalWrite(led6, HIGH);
  digitalWrite(led7, LOW);
  digitalWrite(led8, HIGH);
}

void YELLOW() {
  digitalWrite(led6, LOW);
  digitalWrite (led8, LOW);
  digitalWrite(led7, HIGH);
}
void LED_OFF(){
    digitalWrite(led6, HIGH);
  digitalWrite (led8, HIGH);
  digitalWrite(led7, HIGH);
}


