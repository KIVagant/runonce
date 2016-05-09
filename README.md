RunOnce
=======

About
-----

[RunOnce](bin/runonce) is the php-based Unix tool that help you to run any command only once.
This tool will only execute command and will not waiting for result.

Warnings
-----

NO WARRANTY implied!

Only Unix is supported.
This tool does not working neither in OSX nor in Windows. Tested in RHEL 7.

Installation
-----

Download this repo somewhere or run.

```
composer require kivagant/runonce
```

Usage and examples
-----

Basic usage:

```
 ./bin/runonce your-command
```

Verbose output:
```
 ./bin/runonce -v your-command
```

Example:
```
./bin/runonce php ./cron.php -v=\"2\" && echo 'first launch' || echo 'already running';
> first launch

./bin/runonce -v php ./cron.php -v=\"2\" && echo 'first launch' || echo 'already running';
> Command was already executed with PID  20438
> already running
```

Dependencies
-----
This tool based on the [liip/process-manager](http://github.com/liip/LiipProcessManager.git).

Contributing
-----
Just fork and send me a pull request.