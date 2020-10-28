<?php

namespace App\Utils\Log;

use Illuminate\Contracts\Support\Arrayable;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface as PsrLoggerInterface;
use Monolog\Formatter\LineFormatter;

class FileDailyWriter implements PsrLoggerInterface
{

    const DEFAULT_NAME = 'filewriter';
    protected $levels = [
        'debug'     => Logger::DEBUG,
        'info'      => Logger::INFO,
        'notice'    => Logger::NOTICE,
        'warning'   => Logger::WARNING,
        'error'     => Logger::ERROR,
        'critical'  => Logger::CRITICAL,
        'alert'     => Logger::ALERT,
        'emergency' => Logger::EMERGENCY,
    ];

    protected $fileLoggers = [];
    protected $filenameFormat;
    protected $dateFormat;
    protected $path;

    public $msgJsonEncode;
    public $jsonOptions;
    public $daily;

    public function __construct($daily = false, $path = '', $msgJsonEncode = false, $jsonOptions = 0) {
        $this->path = $path;
        $this->filenameFormat = '{filename}-{date}';
        $this->dateFormat = 'Y-m-d';
        $this->msgJsonEncode = $msgJsonEncode;
        $this->jsonOptions =$jsonOptions;
        $this->daily = $daily;
    }

    public function writeLog($level, $name, $message, array $context = [])
    {
        $message = $this->formatMessage($message, $this->msgJsonEncode, $this->jsonOptions);
        return $this->fileLog($level, $name, $message, $context);
    }

    public function fileLog($level, $name, $message, array $context = [])
    {
        $filename = $this->getFilename($name);
        if( !isset($this->fileLoggers[$filename]) ){
            $this->fileLoggers[$filename] = new Logger($name);
            $this->fileLoggers[$filename]->pushHandler(
                $handler = new StreamHandler(
                    storage_path() .'/logs/'. $filename . '.log',
                    $this->levels[$level]
                )
            );
            $handler->setFormatter($this->getDefaultFormatter());
        }

        return $this->fileLoggers[$filename]->{$level}($message, $context);
    }

    protected function getFilename($name) {
        if ($this->daily) {
            return $this->getTimedFilename($name);
        }
        return $name;
    }

    protected function getTimedFilename($name)
    {
        $timedFilename = str_replace(
            ['{filename}', '{date}'],
            [$name, date($this->dateFormat)],
            $this->filenameFormat
        );
        return $timedFilename;
    }

    //Log::name([option]'level', 'Message'|['msg1', 'msg2']);
    function __call($func, $params){
        $level = 'info';
        $msg = $params[0];
        if (is_string($params[0])) {
            $lowerParams0 = strtolower($params[0]);
            if(in_array($lowerParams0, array_keys($this->levels))){
                $level = $lowerParams0;
                $msg = $params[1];
            }
        }
        return $this->writeLog($level, $func, $msg);
    }

    /**
     * Format the parameters for the logger.
     *
     * @param  mixed  $message
     * @return mixed
     */
    protected function formatMessage($message, $msgJsonEncode = false, $jsonOptions = 0)
    {
        if (is_string($message)) {
            return $message;
        }

        if ($message instanceof \Throwable) {
            return $message->__toString();
        }

        if ($msgJsonEncode) {
            return json_encode($message, $jsonOptions);
        }

        if (is_array($message)) {
            return var_export($message, true);
        } elseif ($message instanceof Jsonable) {
            return $message->toJson();
        } elseif ($message instanceof Arrayable) {
            return var_export($message->toArray(), true);
        }

        return $message;
    }

    /**
     * Get a default Monolog formatter instance.
     *
     * @return \Monolog\Formatter\LineFormatter
     */
    protected function getDefaultFormatter()
    {
        return tap(new LineFormatter(null, null, true, true), function ($formatter) {
            $formatter->includeStacktraces();
        });
    }

    public function json($msgJsonEncode = true, $jsonOptions = JSON_UNESCAPED_UNICODE) {
        $this->msgJsonEncode = $msgJsonEncode;
        $this->jsonOptions = $jsonOptions;
        return $this;
    }

    public function pretty($message, array $context = [])
    {
        if (!is_string($message)) {
            $message = json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $this->writeLog('debug', static::DEFAULT_NAME, $message, $context);
    }

    public function emergency($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, static::DEFAULT_NAME, $message, $context);
    }

    /**
     * Log an alert message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function alert($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, static::DEFAULT_NAME, $message, $context);
    }

    /**
     * Log a critical message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function critical($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, static::DEFAULT_NAME, $message, $context);
    }

    /**
     * Log an error message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function error($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, static::DEFAULT_NAME, $message, $context);
    }

    /**
     * Log a warning message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, static::DEFAULT_NAME, $message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function notice($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, static::DEFAULT_NAME, $message, $context);
    }

    /**
     * Log an informational message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function info($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, static::DEFAULT_NAME, $message, $context);
    }

    /**
     * Log a debug message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, static::DEFAULT_NAME, $message, $context);
    }

    /**
     * Log a message to the logs.
     *
     * @param  string  $level
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $this->writeLog($level, static::DEFAULT_NAME, $message, $context);
    }
}