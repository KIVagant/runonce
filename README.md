RunOnce
=======

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KIVagant/runonce/badges/quality-score.png)](https://scrutinizer-ci.com/g/kivagant/runonce)

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
 ./vendor/bin/runonce your-command
```

Verbose output:
```
 ./vendor/bin/runonce -v your-command
```

**Example 1:**

*Run first command:*
```
./vendor/bin/runonce sleep 10 && echo 'first launch' || echo 'already running';
> first launch
```

*Run another one:* different options are considered as different processes.

```
./vendor/bin/runonce sleep 20 && echo 'first launch' || echo 'already running';
> first launch
```

*Run the first command again:*
```
./vendor/bin/runonce sleep 10 && echo 'first launch' || echo 'already running';
> already running
```

**Example 2:**

*More complex commands:*

```
./vendor/bin/runonce php ./cron.php -v=\"some string\" && echo 'first launch' || echo 'already running';
> first launch

./vendor/bin/runonce -v php ./cron.php -v=\"some string\" && echo 'first launch' || echo 'already running';
> Command was already executed with PID  20438
> already running
```

Dependencies
-----
This tool based on the [liip/process-manager](http://github.com/liip/LiipProcessManager.git).

Contributing
-----
Just fork and send me a pull request.

License
-----
Apache License 2.0