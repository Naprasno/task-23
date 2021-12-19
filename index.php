<?php

echo 'Задание 1.1<br>'; /* ЗАДАНИЕ 1 */
function getFullnameFromParts ($surname, $name, $patronomyc){
    $concat = $surname.' '.$name.' '.$patronomyc;
    return $concat;
};

print_r(getFullnameFromParts("Иванов", "Иван", "Иванович"));
echo '<br><br>';


echo 'Задание 1.2<br>'; /* ЗАДАНИЕ 2 */
function getPartsFromFullname ($concat){
    $keys = [
    'surname', 
    'name', 
    'patronomyc', 
    ];
    
    $result = (explode(' ', $concat));
    return array_combine ($keys, $result);
}
print_r(getPartsFromFullname("Иванов Иван Иванович"));
echo '<br><br>';


echo 'Задание 2<br>'; /* ЗАДАНИЕ 3 */
function getShortName ($concat){
    $arr = getPartsFromFullname ($concat);
    

    //return ($arr['name'].' '. );
    return $arr['name'].' '.mb_substr($arr['surname'],0,1).'.';
};

print_r(getShortName("Иванов Иван Иванович"));
echo '<br><br>';



echo 'Задание 3<br>';/* ЗАДАНИЕ 4 */
function getGenderFromName ($concat){
    $arr = getPartsFromFullname ($concat);
    $sumGender = 0;

    //фамилия на "в" - М , на "ва" - Ж
    if (mb_substr($arr['surname'], -1, 1) == 'в') {
        $sumGender = $sumGender + 1;
    }
    elseif (mb_substr($arr['surname'], -2, 2) == 'ва'){
        $sumGender = $sumGender - 1;
    };

    //имя на "й" или "н" - М , на "а" - Ж
    if ((mb_substr($arr['name'], -1, 1) == 'й') or (mb_substr($arr['name'], -1, 1) == 'н')) {
        $sumGender = $sumGender + 1;
    }
    elseif (mb_substr($arr['name'], -1, 1) == 'а'){
        $sumGender = $sumGender - 1;
    };

    //отчетство на "вич" - М , на "вна" - Ж
    if (mb_substr($arr['patronomyc'], -3, 3) == 'вич') {
        $sumGender = $sumGender + 1;
    }
    elseif (mb_substr($arr['patronomyc'], -3, 3) == 'вна'){
        $sumGender = $sumGender - 1;
    };

    return ($sumGender) ;
};
print_r(getGenderFromName("Иванов Иван Иванович"));
echo '<br><br>';

echo 'Задание 4<br>';/* ЗАДАНИЕ 5 */
include 'example_array.php';
function getGenderDescription ($example_persons_array) {
    $male = 0;
    $female = 0;
    $undef = 0;
    for ($i = 0; $i < sizeof($example_persons_array); $i++) {
        $concat = getGenderFromName ($example_persons_array[$i][fullname]);
            if ($concat > 0) {
             $male = $male + 1;
             $maleProc = ( $male / (count($example_persons_array)) * 100 ) ;
            }
            elseif ($concat < 0){
              $female = $female + 1;
              $femaleProc = ( $female / (count($example_persons_array)) * 100 );
            }
            elseif ($concat == 0){
              $undef = $undef + 1;
              $undefProc = ( $undef / (count($example_persons_array)) * 100 );
            }
    };
    
return ('Гендерный состав аудитории:<br>'.'---------------------------<br>'.'Мужчины - '.round($maleProc).' %<br>Женщины - '.round($femaleProc).' %<br>Не удалось определить - '.round($undefProc).' %');

}
print_r(getGenderDescription($example_persons_array));
echo '<br><br>';


echo 'Задание 5<br>'; /* ЗАДАНИЕ 6 */
function getPerfectPartner  ($F, $I, $O, $example_persons_array) {
    $F = mb_convert_case($F, MB_CASE_TITLE, "UTF-8");
    $I = mb_convert_case($I, MB_CASE_TITLE, "UTF-8");
    $O = mb_convert_case($O, MB_CASE_TITLE, "UTF-8");

    $partnerFIO = getFullnameFromParts ($F, $I, $O);
    $partnerGender = getGenderFromName ($partnerFIO);

    $randNum = array_rand($example_persons_array);
    $randomFIO = $example_persons_array[$randNum][fullname];


    for ($i = 0; $i < sizeof($example_persons_array); $i++) {
        $randNum = array_rand($example_persons_array);
        $randomFIO = $example_persons_array[$randNum][fullname];
        $randomGender = getGenderFromName ($randomFIO);
        $compatibility = round(rand(5000, 10000)/100,2);
        if (($partnerGender > 0 and $randomGender < 0) or ($partnerGender < 0 and $randomGender > 0)) {
            return getShortName ($partnerFIO).' + '.getShortName ($randomFIO).'= <br> ♡ Идеально на '.$compatibility.' % ♡';
            break; 
        }
       
    }
    };

print_r(getPerfectPartner ('пеТров' , 'Петр', 'ПеТРОВич' , $example_persons_array));



?>