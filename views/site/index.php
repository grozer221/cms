<?php ?>
<p>Контент головної сторінки</p>
<?php
    global $Config;
    $db = new \core\DB($Config['Database']['Server'],
        $Config['Database']['Username'],
        $Config['Database']['Password'],
        $Config['Database']['Database']);
        /*for($i = 0; $i < 10; $i++)
        $db->insert('news',
        [
            'title'=>'Новина'.$i,
            'text' => 'text'.$i,
           'date' => '2020-12-12',
            'time' => '11:22'
        ]);*/
        //var_dump($db->select('news', '*', null,['id' => 'DESC'],5, 5));
//       $db->update('news',
//           ['title' => 'Новий заголовок'],
//        ['id' => 1]);
//    $db->delete('news',
//    ['id' => 1]);
