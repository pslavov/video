<div class="video list">
  <?php if (count($vids)) { ?>
    <?php foreach ($vids as $v) { ?>
      <?= $this->Html->link($v['Video']['file'],
                            array(
                                'controller' => 'video',
                                'action' => 'get',
                                $v['Video']['video_id']
                            )) ?><br />
    <?php } ?>
  <?php } ?>
  ?>
</div>
