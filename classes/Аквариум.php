<?php
/**
 * Created by PhpStorm.
 * User: lexi
 * Date: 30.01.18
 * Time: 21:50
 */

class Аквариум
{
    public $орешек = null;
    private $рыбки = [];
    private $предыдущаяУспевшаяРыбка;

    public function запуститьРыбку(string $рыбка, string $имяРыбки = null)
    {
        /**@var Рыба $новаяРыбка */
        $новаяРыбка = new $рыбка();
        $новаяРыбка->имя = is_null($имяРыбки) ? $рыбка : $имяРыбки;
        $новаяРыбка->средаОбитания = $this;
        $this->рыбки[] = $новаяРыбка;
    }

    public function рыбкиХотятКушать(): bool
    {
        return array_reduce(
            $this->рыбки,
            function ($естьГолодные, $рыбка) {
                /* @var $рыбка Рыба */
                return $естьГолодные || $рыбка->ещеГолодна();
            },
            false);
    }

    public function датьОрешек(Орешек $орешек)
    {
        $this->орешек = $орешек;
    }

    public function рыбкиУстремилисьЗаОрешком(): Рыба
    {
        $this->предыдущаяУспевшаяРыбка= array_reduce(
            array_filter($this->рыбки,
                function ($рыбка) {
                    /* @var Рыба $рыбка */
                    return $рыбка->ещеГолодна();
                }),
            function ($перваяРыбка, $рыбка) {
                /**
                 * @var Рыба $рыбка
                 * @var Рыба $перваяРыбка
                 */
                Log::console("{$рыбка->имя} устремляется за орешком со скоростью {$рыбка->текущаяСкорость()}.");
                return (is_null($перваяРыбка) || $рыбка->текущаяСкорость() > $перваяРыбка->текущаяСкорость()) ? $рыбка : $перваяРыбка;

            },
            null);
        return $this->предыдущаяУспевшаяРыбка;
    }

    public function перечислитьНеСкушавшихОрешек(){
        foreach (array_filter($this->рыбки, function ($рыбка) {/* @var $рыбка Рыба */ return $рыбка->ещеГолодна();}) as $рыбка) {
            if($рыбка!=$this->предыдущаяУспевшаяРыбка)
                Log::console("{$рыбка->имя} не успевает.");
        }
    }

}