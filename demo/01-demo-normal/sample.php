<?php

require __DIR__.'/../../vendor/autoload.php';

use Overtrue\Pinyin\Pinyin as Pinyin;

// 小内存型
$pinyin = new Pinyin(); // 默认
// 内存型
// $pinyin = new Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
// I/O型
// $pinyin = new Pinyin('Overtrue\Pinyin\GeneratorFileDictLoader');

// $py = $pinyin->convert('带着希望去旅行，比到达终点更美好二重唱');
// print_r($py);exit;
// ["dai", "zhe", "xi", "wang", "qu", "lv", "xing", "bi", "dao", "da", "zhong", "dian", "geng", "mei", "hao"]

$py = $pinyin->convert('带着希望去旅行，比到达终点更美好', PINYIN_UNICODE);
print_r($py);
// ["dài","zhe","xī","wàng","qù","lǚ","xíng","bǐ","dào","dá","zhōng","diǎn","gèng","měi","hǎo"]

// $py = $pinyin->convert('带着希望去旅行，比到达终点更美好', PINYIN_ASCII);
// print_r($py);
//["dai4","zhe","xi1","wang4","qu4","lv3","xing2","bi3","dao4","da2","zhong1","dian3","geng4","mei3","hao3"]

