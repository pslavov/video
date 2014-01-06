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
  </div>
  <div class="middle">
    <?php 
      if (count($vids[$dir_key]) > 0) {
        foreach($vids[$dir_key] AS $k => $v) {
          if (in_array($k, array('video_dir', 'mtime', 'count')))
            continue;
            
          $link = $this->Html->link(
                                $v['file'],
                                array('controller' => 'videos',
                                      'action' => 'get',
                                      $v['video_id']
                                )
                              );
          echo $link;
          echo "<br />";
        }
      }
    ?>
  </div>
</div>
