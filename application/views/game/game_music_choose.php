    <tr>
      <td><a href="<?php echo base_url(); ?>game/game_step/<?php echo $id_music; ?>"><button class="button-primary twelve columns">Play</button></a></td>
      <td><?php echo $title; ?></td>
      <td><?php echo $album; ?></td>
      <td>
	  <?php
		$i = 0;
		foreach($artists as $artist) {
			if($i!=0)
				echo ', '.$artist;
			else
				echo $artist;
			
			$i++;
		}
	  ?>
	  </td>
    </tr>