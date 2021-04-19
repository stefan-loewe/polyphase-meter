# polyphase-meter
This project enables to read data from the polyphase meter LK13BE by Logarex

# What is polyphase-meter?
polyphase-meter allows anybody to read data from a polyphase meter LK13BE built by Logarex.

# What is needed to start using polyphase-meter?
You will need PHP 7.4, Composer and a clone from this repository, and of course an [IR reader](https://wiki.volkszaehler.org/hardware/controllers/ir-schreib-lesekopf-usb-ausgang).

# How to run polyphase-meter?
0. Connect the IR reader to your LK13BE and the USB plug to your computing device. Adding `udev` rules is advisable, but out of scope of this readme.
1. Let us assume that data from the IR reader is available from `/dev/ttyUSB0`.
2. Clone this reposistory via `git clone https://github.com/stefan-loewe/polyphase-meter.git`.
3. Change to the root folder of the checkout via `cd polyphase-meter`.
4. run `php composer.phar update && php composer.phar dump` to fetch dependencies and create autoload files.
5. Initialize the connection to the IR reader `stty -F /dev/ttyUSB0 1:0:8bd:0:3:1c:7f:15:4:5:1:0:11:13:1a:0:12:f:17:16:0:0:0:0:0:0:0:0:0:0:0:0:0:0:0:0 2>/dev/null`.
6. Run `php src/demo.php`.
7. Output similar to the below should be printed:
```
raw data: /LOG5LK13BE803049

1-0:96.1.0*255(001LOG0064800017)
1-0:1.8.0*255(000000.4392*kWh)
1-0:1.8.1*255(000000.0000*kWh)
1-0:1.8.2*255(000000.4392*kWh)
1-0:2.8.0*255(000000.8322*kWh)
1-0:16.7.0*255(000000*W)
1-0:32.7.0*255(000.0*V)
1-0:52.7.0*255(000.0*V)
1-0:72.7.0*255(229.9*V)
1-0:31.7.0*255(000.00*A)
1-0:51.7.0*255(000.00*A)
1-0:71.7.0*255(000.03*A)
1-0:81.7.1*255(000*deg)
1-0:81.7.2*255(000*deg)
1-0:81.7.4*255(000*deg)
1-0:81.7.15*255(000*deg)
1-0:81.7.26*255(000*deg)
1-0:14.7.0*255(49.9*Hz)
1-0:1.8.0*96(00000.0*kWh)
1-0:1.8.0*97(00000.0*kWh)
1-0:1.8.0*98(00000.0*kWh)
1-0:1.8.0*99(00000.0*kWh)
1-0:1.8.0*100(00000.4*kWh)
1-0:0.2.0*255(ver.03,EF8C,20170504)
1-0:96.90.2*255(0C69)
1-0:97.97.0*255(00000000)
!
/LOG5LK13BE803049
```

# Further information
- [Manual for the LK13BE](https://www.kommenergie.de/_Resources/Persistent/d9485ccfb652107fdab8a0f8b6bbe6fea8393547/Bedienungsanleitung%20Logarex%20Z%C3%A4hler.pdf)
- [Technical documentation of LK13BE](https://www.stadtwerke-burgdorf-netz.de/_Resources/Persistent/9450d40cdc3d62d8de38a3e4b06ad5d6805c87b4/Gebrauchsanleitung_LK13BE8030x9.pdf)
- [Das volkszaehler Projekt](https://volkszaehler.org/) und dessen [Wiki](https://wiki.volkszaehler.org/)
- My [blog post](https://www.photovoltaikforum.com/wissen/entry/52-auslesen-von-stromverbrauch-stromproduktion-strombezug-von-stromz%C3%A4hler-logarex-l/) in the [photovoltaikforum](https://www.photovoltaikforum.com)

# Thanks
- [Der Karl](http://automaten-karl.de/blog/?p=914) where I got a few insights. However, that solution only seems to work for the polyphase meter LK13BD by Logarex.
- [KorbinianP](https://knx-user-forum.de/forum/%C3%B6ffentlicher-bereich/geb%C3%A4udetechnik-ohne-knx-eib/42090-digitale-stromz%C3%A4hler-auslesen-logarex-lk13b) on which my solution is based, [by migrating his shell script](https://gist.github.com/KorbinianP/62bfa2b2140af78b977c6476bc6859ee) to PHP.
