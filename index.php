<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>Модуль 12</title>
    <link rel="stylesheet" href="style.css">
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

        function getFullnameFromParts($surname, $name, $patronomyc)
        {
            $fullname = $surname . ' ' . $name . ' ' . $patronomyc;
            return $fullname;
        }

        $fullname = $example_persons_array[1]['fullname'];

        function getPartsFromFullname($fullname)
        {
            $resfull = explode(' ', $fullname);

            return [
                'surname' => $resfull[0],
                'name' => $resfull[1],
                'patronomyc' => $resfull[2]
            ];
        }


        function getShortName($fullname)
        {
            $respart = getPartsFromFullname($fullname);
            $shortname = $respart['name'] . ' ' . mb_substr($respart['surname'], 0, 1) . '.';
            return $shortname;
        }


        function getGenderFromName($fullname)
        {
            $respart = getPartsFromFullname($fullname);
            $sum = 0;
            if ((mb_substr($respart['patronomyc'], -2, 2) === 'ич') || (mb_substr($respart['name'], -1, 1) === 'й') || (mb_substr($respart['name'], -1, 1) === 'н') || (mb_substr($respart['surname'], -1, 1) === 'в')) {
                $sum += 1;
            }
            else {
                if ((mb_substr($respart['patronomyc'], -2, 2) === 'вна') || (mb_substr($respart['name'], -1, 1) === 'а') || (mb_substr($respart['surname'], -2, 2) === 'ва')) {
                    $sum -= 1;
                }
                else {
                    $sum = 0;
                }
            }
            
            if ($sum > 0) {
                return 'Мужской';
            } else {
                if ($sum < 0) {
                    return 'Женский';
                } else {
                    return 'Не определено';
                }
            }
        }


        function getGenderDescription($persons_array)
        {
            $men = array_filter($persons_array, function ($persons_array) {
                return (getGenderFromName($persons_array['fullname']) == 'Мужской');
            });

            $women = array_filter($persons_array, function ($persons_array) {
                return (getGenderFromName($persons_array['fullname']) == 'Женский');
            });

            $undefinded = array_filter($persons_array, function ($persons_array) {
                return (getGenderFromName($persons_array['fullname']) == 'Не определено');
            });

            $number = count($men) + count($women) + count($undefinded);
            $menNumber = round(count($men) / $number * 100, 2);
            $womenNumber = round(count($women) / $number * 100, 2);
            $undefindedNumber = round(count($undefinded) / $number * 100, 2);

            echo <<<HEREDOCLETTER
            Гендерный состав аудитории:<br>
            ---------------------------<br>
            Мужчины - $menNumber%<br>
            Женщины - $womenNumber%<br>
            Не удалось определить - $undefindedNumber%<br>
            HEREDOCLETTER;
        }


        function getPerfectPartner($surname, $name, $patronomyc, $persons_array)
        {

            $surnameConverted = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE);
            $nameConverted = mb_convert_case($name, MB_CASE_TITLE_SIMPLE);
            $patronomycConverted = mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE);

            $fullname = getFullnameFromParts($surnameConverted, $nameConverted, $patronomycConverted);
            $gender = getGenderFromName($fullname);

            $randNum = rand(0, count($persons_array)-1);

            $randomPerson = $persons_array[$randNum]['fullname'];
            $randomGender = getGenderFromName($randomPerson);

            while ($gender === $randomGender || $randomGender === "Не определено") {
                $randNum = rand(0, count($persons_array)-1);
                $randomPerson = $persons_array[$randNum]['fullname'];
                $randomGender = getGenderFromName($randomPerson);
            };

            $firstPerson = getShortName($fullname);
            $secondPerson = getShortName($randomPerson);
            $percent = mt_rand(5000, 10000) / 100;

            echo <<<HEREDOCLETTER
            $firstPerson + $secondPerson =
            ♡ Идеально на $percent% ♡
            HEREDOCLETTER;
        }

        ?>

        <h2><?php echo "getFullnameFromParts"?></h2>
        <p><?php print_r(getFullnameFromParts('Иванов', 'Иван', 'Иванович')); ?></p>

        <h2><?php echo "getPartsFromFullname"?></h2>
        <p><?php print_r(getPartsFromFullname($fullname)); ?></p>

        <h2><?php echo "getShortName"?></h2>
        <p><?php print_r(getShortName($fullname)); ?></p>

        <h2><?php echo "getGenderFromName"?></h2>
        <p><?php print_r(getGenderFromName($fullname)); ?></p>
        
        <h2><?php echo "getGenderDescription"?></h2>
        <p><?php print_r(getGenderDescription($example_persons_array)); ?></p>

        <h2><?php echo "getPerfectPartner"?></h2>
        <p><?php print_r(getPerfectPartner("ИваНов", "ИВан", "ИвановИч", $example_persons_array)); ?></p>

    </main>
    <footer>
        <div class="FIO">FIO <span>&copy;&nbsp;ФИО</span></div>
    </footer>
</body>

</html>