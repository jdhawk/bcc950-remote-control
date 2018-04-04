# bcc950-remote-control
Remote Control for the Logitech BCC 950 Conference Camera in Linux

#This will use the UVC commands available through Video4Linux to allow a webpage to remotely control the Pan/Tilt/Zoom features of the BCC 950.


* You'll need the v4l2-ctl command available (v4l-utils package on Fedora)  
* Edit the `$Device` variable to point to correct webcam device (you can get a list using `v4l2-ctl --list-devices`)
* Easiest way to get this live is using `php -S <IP>:<PORT>` - it will need to run as a user with the correct privlidges to issue the v4l2-ctl commands.
* You can increase or decrease `$SleepStep` to make the button clicks move the camera more or less. 
