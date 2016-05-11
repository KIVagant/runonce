<?php
namespace KIVagant\RunOnce;

use Liip\ProcessManager\LockException;
use Liip\ProcessManager\ProcessManager;
use Liip\ProcessManager\PidFile;

class RunOnce
{
    protected $debug = false;
    protected $arguments = [];

    /**
     * @var ProcessManager
     */
    private $processManager;

    /**
     * @var PidFile
     */
    private $pidFile;

    public function __construct(ProcessManager $processManager, $argv)
    {
        $this->processManager = $processManager;
        $this->readArguments($argv);
        $pidFile = $this->pidFileFactory($processManager);
        $this->pidFile = $pidFile;
    }

    public function __invoke()
    {
        try {
            $this->acquireLock();
            $this->execCommand();
        } catch (RuntimeException $e) {
            $this->releaseLock();
            echo $e->getMessage(), PHP_EOL;

            return false;
        } catch (LockException $e) {
            $locker = $this->pidFile->getPid();
            if ($this->processManager->isProcessRunning($locker)) {
                $this->debug('Command was already executed with PID ', $locker);

                return false;
            }
            $this->debug($locker . ' lock released');
            $this->releaseLock();
            $this->acquireLock();
            $this->execCommand();
        }

        return true;
    }

    protected function readArguments($argv)
    {
        $this->arguments = $argv;
        unset($this->arguments[0]);
        if (array_key_exists(1, $this->arguments) && $this->arguments[1] === '-v') {
            $this->debug = true;
            unset($this->arguments[1]);
        }

        return $this->arguments;
    }

    protected function acquireLock()
    {
        $this->pidFile->acquireLock();
    }

    protected function releaseLock()
    {
        $this->pidFile->acquireLock();
    }

    protected function execCommand()
    {
        $command = implode(' ', $this->arguments);
        if (empty($command)) {
            throw new RuntimeException('You need to set a command as the argument to this tool');
        }
        $this->debug($command);
        $runningPid = $this->pidFile->execProcess($command);
        $this->pidFile->setPid($runningPid);
        $this->debug($runningPid, ' is executed and locked');
    }

    protected function debug()
    {
        if ($this->debug) {
            echo implode(' ', func_get_args()), PHP_EOL;
        }
    }

    protected function pidFileFactory(ProcessManager $processManager)
    {
        $argsHash = md5(implode(' ', $this->arguments));
        $pidFile = new PidFile($processManager, PID_DIR . PID_FILE . '.' . $argsHash . '.pid');

        return $pidFile;
    }
}
