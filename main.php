<?PHP
    # Общий класс для животных
    class Animal {
        private $type; # Тип животного (string)
        private $product_name; # Название продукта, которое даёт животное (string)
        private $profit_min; # Минимальное количество продукта, которое даёт животное за один день (int)
        private $profit_max; # Максимальное количество продукта, которое даёт животное за один день (int)

        function __construct($type, $product_name, $profit_min, $profit_max) {
            $this->type = $type;
            $this->product_name = $product_name;
            $this->profit_min = $profit_min;
            $this->profit_max = $profit_max;
        }

        # Получить тип животного
        public function getType() {
            return $this->type;
        }

        # Получить название продукта
        public function getProductName() {
            return $this->product_name;
        }

        # Собрать продукт за один день
        public function getProduct() {
            return random_int($this->profit_min, $this->profit_max);
        }
    }

    # Класс коровы
    class Cow extends Animal {

        function __construct() {
            parent::__construct("cow", "milk", 8, 12);
        }
    }

    # Класс курицы
    class Chicken extends Animal {

        function __construct() {
            parent::__construct("chicken", "egg", 0, 1);
        }
    }

    # Класс фермы
    class Farm {
        private $animals; # Список всех живтных. У каждого животного есть свой номер. (array)
        private $animal_type_amount; # Количество каждого вида животных на ферме (array)
        private $product_type_amount; # Количество каждого вида продукции, собранной за недею (array)
        private $product_amount_general; # Общее количество продукции, собранной за неделю (int)

        function __construct() {
            $this->animals = array();
            $this->animal_type_amount = array();
            $this->product_type_amount = array();
            $this->product_amount_general = 0;
        }

        # Добавить новое животное
        #   $animal_class - объект животного. Например addAnimal(new Cow())
        public function addAnimal($animal_class) {
            $this->animals[] = $animal_class; # Добавить новое животное в список и дать ему номер
            $animal_type = end($this->animals)->getType(); # Получить тип животного
            $product_type = end($this->animals)->getProductName(); # Получить назавние продукта
            
            if (isset($this->animal_type_amount[$animal_type])) { # Если такой вид животных уже есть в списке
                $this->animal_type_amount[$animal_type] += 1; # Увеличить значение количества животных данного типа
            } else {
                $this->animal_type_amount[$animal_type] = 1; # Сделать первую запись о животном данного вида
                $this->product_type_amount[$product_type] = 0; # Сделать первую запись о количетве продуктов, собранных у животного данного вида
            }
        }

        # Получить количество животных указанного вида
        public function getTypeAmount($type_name) {
            if (isset($this->animal_type_amount[$type_name])) { 
                return $this->animal_type_amount[$type_name];
            } else {
                return 0;
            }
        }

        # Получить общее количество собранных продуктов за неделю
        public function getProductsAmountGeneral() {
            return $this->product_amount_general;
        }

        # Получить количество продуктов указанного вида собранных за неделю
        public function getProductsAmount($product_name) {
            return $this->product_type_amount[$product_name];
        }

        # Получить количество животных указанного вида
        public function getAnimalsAmount($animal_type) {
            return $this->animal_type_amount[$animal_type];
        }

        # Собрать продукты со всех животных за один день
        private function harvestDay() {
            for ($i = 0; $i < count($this->animals); $i++) {
                $product_amount = $this->animals[$i]->getProduct();
                $this->product_amount_general += $product_amount;
                $this->product_type_amount[$this->animals[$i]->getProductName()] += $product_amount;
            }

        }

        # Собрать продукты со всех животных за неделю
        public function harvestWeek() {
            $this->product_amount_general = 0; # Обнулить количество собранных продуктов за неделю

            for ($i = 0; $i < count($this->animals); $i++) {
                $this->product_type_amount[$this->animals[$i]->getProductName()] = 0; # Обнулить количество собранных продуктов за неделю
            }

            # Собрать продукты 7 раз
            for ($i = 0; $i < 7; $i++) {
                $this->harvestDay();
            }

        }
    }

    # Создать объект фермы
    $farm = new Farm();

    # Добавить 10 коров
    for ($i = 1; $i <= 10; $i++) {
        $farm->addAnimal(new Cow());
    }
    echo "Количество коров: ". $farm->getAnimalsAmount("cow") ."\n";

    # Добавить 20 кур
    for ($i = 1; $i <= 20; $i++) {
        $farm->addAnimal(new Chicken());
    }
    echo "Количество кур: ". $farm->getAnimalsAmount("chicken") ."\n";

    # Собрать продукцию за неделю
    $farm->harvestWeek();
    echo "Общее количество собранных продуктов за неделю: ". $farm->getProductsAmountGeneral() ."\n";
    echo "Количество литров молока собранного за неделю: ". $farm->getProductsAmount("milk") ."\n";
    echo "Количество яиц собранных за неделю: ". $farm->getProductsAmount("egg") ."\n";


    # Добавить 5 кур
    for ($i = 1; $i <= 5; $i++) {
        $farm->addAnimal(new Chicken());
    }
    echo "Добавлено 5 кур. Количество кур: ". $farm->getAnimalsAmount("chicken") ."\n";

    # Добавить 1 корову
    $farm->addAnimal(new Cow());
    echo "Добавлена 1 корова. Количество коров: ". $farm->getAnimalsAmount("cow") ."\n";

    # Собрать продукцию за неделю
    $farm->harvestWeek();
    echo "Общее количество собранных продуктов за неделю: ". $farm->getProductsAmountGeneral() ."\n";
    echo "Количество литров молока собранного за неделю: ". $farm->getProductsAmount("milk") ."\n";
    echo "Количество яиц собранных за неделю: ". $farm->getProductsAmount("egg") ."\n\n";

    
?>