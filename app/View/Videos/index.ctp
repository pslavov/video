<div class="videoList">
  <div class="leftMenu">
    <ul class='videoDirs'>
    <?php
      if (count($vids)) {
        foreach ($vids AS $k => $v) {
          $class = '';
          if ($v['video_dir'] == $dir) {
            $class = 'current';
            $dir_key = $k;
          }
          echo "<li class=".$class.">".
                $this->Html->link(
                                $v['video_dir'],
                                array('controller' => 'videos',
                                      'action' => 'index',
                                      urlencode($v['video_dir'])
                                )
                              ). " (<strong>".$v['count']."</strong>)</li>";
        }
      }
    ?>
    </ul>
    <span class="debug"></span>
  </div>
  <div class="middle">
    <?php 
      if (count($vids[$dir_key]) > 0) {
        foreach($vids[$dir_key] AS $k => $v) {
	  if ($k and in_array($k, array('video_dir', 'mtime', 'count'))) {
		continue;
	  }

          $link = $this->Html->link(
                                $v['file'],
                                array('controller' => 'videos',
                                      'action' => 'get',
                                      $v['video_id']
                                )
                              );
          $v_url = 'http://'.$luser.':'.$lpwd.'@home.peshka.org/t'.preg_replace('#^'.$video_dir.'#', '', $v['dir']).'/'.urlencode($v['file']);
          //echo $link;
          //echo "<br />"; ?>
          <div class="oneVideo oneVideo<?= $v['video_id']?>">
            <div class="VideoButons">
              <span class="showButton showButton<?= $v['video_id']?>" onClick="showVideo(<?= $v['video_id']?>);">Show</span>
              <span class="hideButton hideButton<?= $v['video_id']?>" onClick="hideVideo(<?= $v['video_id']?>);">Hide</span>
              <span class="title"><a href="<?= $v_url?>"><?= $v['file']?> (<?= $v['mime']?>)</a></span>
            </div>
            <div class="videoContent videoContent<?= $v['video_id']?>">
              <span class="writeVideo writeVLC" onClick="writeVLC(<?= $v['video_id']?>, '<?= $v['ext']?>')">VLC Plugin</span>
              <span class="writeVideo writeJW" onClick="writeJW(<?= $v['video_id']?>, '<?= $v['file']?>', '<?= $v['ext']?>')">JW player</span>
              <span class="writeVideo writeHTML5" onClick="writeHTML5(<?= $v['video_id']?>, '<?= $v['mime']?>', '<?= $v['ext']?>')" >HTML5</span>
              <span class="writeVideo"><?= ($v['encoded'] ? 'E' : 'Not e' )?>ncoded </span>
              <div class="playerContent playerContent<?= $v['video_id']?>">
                1
              </div>
            </div>
          </div>
    <?php
        }
      }
    ?>
  </div>
</div>
