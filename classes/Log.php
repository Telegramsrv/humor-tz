<?php
/**
 * Created by PhpStorm.
 * User: lexi
 * Date: 30.01.18
 * Time: 23:30
 */

class Log
{
    static $instance = null;
    public $line = 1;
    public $onWrite;
    private $currentText = '';
    private $session = '';
    public static function getInstance()
    {
        self::$instance = is_null(self::$instance) ? new self() : self::$instance;
        return self::$instance;
    }

    public function __construct()
    {
        /*это чтобы мы могли отличить одну симуляцию от другой*/
        try {
            $this->session = bin2hex(random_bytes(5));
        } catch (Exception $e) {
        }
        $this->onWrite = function ($v) {};
    }

    /*сокращаем строку вывода на консколь. Экономим ресурсы клавиатуры */
    public static function console($text)
    {
        return self::getInstance()->logToConsole($text);
    }

    /*выводим в консоль, вызываем замыкание. Все готово!*/
    public function logToConsole($text)
    {
        $this->currentText = "$text (ход {$this->line})";
        $this->write();
        echo $this->currentText . PHP_EOL;
        return $this;
    }

    /* счетчик шагов */
    public function step()
    {
        $this->line++;
    }

    /*
     * обернул вызов замыкания в отдельный метод, потому что код немного специфичен и способен сбить с толку
     * */
    private function write()
    {
        ($this->onWrite)(['sess' => $this->session, 'text' => $this->currentText]);
    }

}