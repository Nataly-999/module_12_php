<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Модуль 12</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Модуль 12. Работа с ФИО</h1>
    </header>
    <main>

    <?php
        $example_persons_array = [
            [
                'fullname' => 'Иванов Иван Иванович',
                'job' => 'tester',
            ],
            [
                'fullname' => 'Степанова Наталья Степановна',
                'job' => 'frontend-developer',
            ],
            [
                'fullname' => 'Пащенко Владимир Александрович',
                'job' => 'analyst',
            ],
            [
                'fullname' => 'Громов Александр Иванович',
                'job' => 'fullstack-developer',
            ],
            [
                'fullname' => 'Славин Семён Сергеевич',
                'job' => 'analyst',
            ],
            [
                'fullname' => 'Цой Владимир Антонович',
                'job' => 'frontend-developer',
            ],
            [
                'fullname' => 'Быстрая Юлия Сергеевна',
                'job' => 'PR-manager',
            ],
            [
                'fullname' => 'Шматко Антонина Сергеевна',
                'job' => 'HR-manager',
            ],
            [
                'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
                'job' => 'analyst',
            ],
            [
                'fullname' => 'Бардо Жаклин Фёдоровна',
                'job' => 'android-developer',
            ],
            [
                'fullname' => 'Шварцнегер Арнольд Густавович',
                'job' => 'babysitter',
            ],
        ];

        function getFullnameFromParts ($surname, $name, $patronomyc){
            $fullname = $surname . ' ' . $name . ' ' . $patronomyc;
            return $fullname;
        };
        echo getFullnameFromParts ('Иванов', 'Иван', 'Иванович');

        $fullname = $example_persons_array['5']['fullname'];

        function getPartsFromFullname ($fullname){
            $resfull = explode(' ', $fullname);
            $respart = ['surname' => $resfull[0],
                        'name' => $resfull[1],
                        'patronomyc' => $resfull[2]];
        return $respart;
        };
        print_r(getPartsFromFullname ($fullname));

        function getShortName ($fullname){
            $respart = getPartsFromFullname($fullname);
            $shortname = $respart['name'] . ' ' . mb_substr($respart['surname'], 0, 1) . '.';
            return $shortname;
        };
        echo getShortName ('Иванов Иван Иванович');

        function getGenderFromName ($fullname){
            $respart = getPartsFromFullname($fullname);
            $sum = 0;
            if ((mb_substr($respart['patronomyc'], -2, 2) === 'ич') || (mb_substr($respart['name'], -1, 1) === 'й') || (mb_substr($respart['name'], -1, 1) === 'н') || (mb_substr($respart['surname'], -1, 1) === 'в')) {
                $sum +=1;
            } else {
                if ((mb_substr($respart['patronomyc'], -2, 2) === 'вна') || (mb_substr($respart['name'], -1, 1) === 'а') || (mb_substr($respart['surname'], -2, 2) === 'ва')) {
                $sum -=1;
                } else $sum = 0;}
            if ($sum > 0) {
                return 'Мужской';
            } else {
                if ($sum < 0) {
                    return 'Женский';
                } else {
                    return 'Не определено';
                } 
            }
        };

        function getGenderDescription ($example_persons_array){

            $men = array_filter($example_persons_array, function($example_persons_array) {
                return (getGenderFromName($example_persons_array['fullname']) == 'Мужской');
            });

            $women = array_filter($example_persons_array, function($example_persons_array) {
                return (getGenderFromName($example_persons_array['fullname']) == 'Женский');
            });

            $undefinded = array_filter($example_persons_array, function($example_persons_array) {
                return (getGenderFromName($example_persons_array['fullname']) == 'Не определено');
            });

            $number = count($men) + count($women) + count($undefinded);
            $menNumber = round(count($men) / $number * 100,2);
            $womenNumber = round(count($women) / $number * 100,2);
            $undefindedNumber = round(count($undefinded) / $number * 100,2);

            echo <<<HEREDOCLETTER
            Гендерный состав аудитории:
        ---------------------------
            Мужчины - $menNumber%
            Женщины - $womenNumber%
            Не удалось определить - $undefindedNumber%
            HEREDOCLETTER;
        };

        function getPerfectPartner ($surname, $name, $patronomyc, $example_persons_array){

            $surname = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE) . "\n";
            $name = mb_convert_case($name, MB_CASE_TITLE_SIMPLE) . "\n";
            $patronomyc = mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE) . "\n";

            $fullname = getFullnameFromParts($surname, $name, $patronomyc);
            $gender = getGenderFromName ($fullname);

            $randomPerson = $example_persons_array(array_rand['fullname']);
            $randomGender = getGenderFromName($randomPerson);

            while ($gender === $randomGender || $randomGender === "Не определено"){
                $randomPerson = $example_persons_array(array_rand['fullname']);
                $randomGender = getGenderFromName($randomPerson);
            };
    
            $firstPerson = getShortName($fullname);
            $secondPerson = getShortName($randomPerson);
            $percent = mt_rand(5000, 10000)/100;
    
            echo <<<HEREDOCLETTER
            $firstPerson + $secondPerson =
            ♡ Идеально на $percent% ♡
            HEREDOCLETTER;
        };

    ?>

    </main>
    <footer>
        <div class="FIO">FIO <span>&copy;&nbsp;ФИО</span></div>
    </footer>
</body>
</html>