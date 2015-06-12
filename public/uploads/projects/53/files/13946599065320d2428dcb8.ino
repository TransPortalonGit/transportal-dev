/* 
  Piano

  Using 8 push buttons attached to pins 2 thou 9 and a speaker 
  attached to pin 13. Create a C minor piano. The button on pin
  2 will play a low C and the button on pin 9 will play middle c.
  
  The Circuit. 
    * push buttons attached to pins 2 thou 9 from ground
    * speaker attached to pin 13 from ground
    
  With this basic setup you can easily add 3 more notes. You can
  also go in and change the frequency to get the notes you desire. 
  
  created 20 Jan 2010
  by digimike// adjusted by Xiaofen

*/
#include <Tone.h>
boolean button[] = { 1, 2, 3, 4, 5, 6, 7 };  //create array for button pins
boolean led[] = {8,9,10,11,12};  //create array for led pins
boolean speakerpin = 13;  //sets speaker pin

//int ledpin = 12;

boolean buttonset = 0;  //variable for reading button push
int tone1 = 0;  //variable for setting musical note tone of 1,2,3: 1915, 1700, 1519,
//int tones[] = { 1915, 1700, 1519};

void setup() {
  // set all pins to output
  pinMode(speakerpin, OUTPUT);
 
  for(int x=0; x<7; x++) {
    pinMode(button[x], OUTPUT);
     pinMode(led[x], OUTPUT);
  }
  // buttons are in the high position
  for(int x=0; x<7; x++) {
    digitalWrite(button[x], HIGH);
    digitalWrite(led[x], LOW);
  }
}

void loop()
{
  // checks the state of each button
  for(int x=0; x<7; x++) {
    buttonset = digitalRead(button[x]);
    
   if(buttonset == LOW && button[x] == 1) {
      tone1 = 2100;
        digitalWrite(led[0], HIGH);
    }else{
      digitalWrite(led[0], LOW);
    }
    
    if(buttonset == LOW && button[x] == 2){ // if button on pin 2 is pressed
      tone1 = 1870;    //stores the note's wavelength to be played. 
       digitalWrite(led[1], HIGH);
    }else{
      digitalWrite(led[1], LOW);
    }
    if(buttonset == LOW && button[x] == 3) {
      tone1 = 1670;
        digitalWrite(led[2], HIGH);
    }else{
      digitalWrite(led[2], LOW);
    }
     if(buttonset == LOW && button[x] == 4) {
      tone1 = 1580;
       digitalWrite(led[3], HIGH);
    }else{
      digitalWrite(led[3], LOW);
    }
     if(buttonset == LOW && button[x] == 5) {
      tone1 = 1400;
       digitalWrite(led[4], HIGH);
    }else{
      digitalWrite(led[4], LOW);
    }
     if(buttonset == LOW && button[x] == 6) {
      tone1 = 1250;
    }
     if(buttonset == LOW && button[x] == 7) {
      tone1 = 1110;
       
    }
 
   
  while(tone1 > 0) {    // as long as there is a not to be played
  digitalWrite(speakerpin, HIGH);    // turn on 5V to speaker
  delayMicroseconds(tone1);    // delay the designated wavelength in ms
  digitalWrite(speakerpin, LOW);    // turn off speaker
  delayMicroseconds(tone1);    // delay the designated wavelength in ms
  tone1 = 0;   // resets tone variable to 0 so the tone dosn't play constantly
  }
  
}

}
  
