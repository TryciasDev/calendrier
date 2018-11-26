<?= ($day)."
" ?>
<br>
<?php foreach (($datas?:[]) as $ikey=>$jour): ?>
    
<a href="/comment/<?= ($jour->idEvent) ?>">cible : <?= ($jour->target) ?></a>
<br>
auteur : <?= ($jour->author)."
" ?>
<br>
description : <?= ($jour->description)."
" ?>
<br>
isDone : <?= ($jour->isDone)."
" ?>
<br>
_____________________
<?php endforeach; ?>
