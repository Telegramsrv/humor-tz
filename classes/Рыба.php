<?php
/**
 * Created by PhpStorm.
 * User: lexi
 * Date: 30.01.18
 * Time: 21:33
 */

class Рыба
{
    public $средаОбитания;
    public $сытость;
    public $скорость;
    public $времяСозерцанияОрешка = 0;
    public $имя;

    public function текущаяСытость()
    {
        return $this->сытость;
    }

    public function текущаяСкорость()
    {
        return $this->сытость < 5 ? ($this->скорость + round($this->скорость / $this->сытость, 2)) : $this->скорость;
    }

    public function неГотоваСкушатьОрешек(Орешек $орешек)
    {
        $орешек->выбранРыбкой=true;
        return false; //$this->времяСозерцанияОрешка!=0; по умолчанию рыбка всегда готова скушать орешек
    }

    public function скушалаОрешек(Орешек $орешек)
    {
        $this->времяСозерцанияОрешка = 0;
        $this->сытость += $орешек->сытность;
    }

    public function ещеГолодна(){
        return $this->сытость<10;
    }

    public function созерцаетОрешек(){
        $this->времяСозерцанияОрешка +=1;
    }
}