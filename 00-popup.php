<!-- Popup -->
<style>
.padding-teste1{
    padding-right: 50% !important;
}
.padding-teste2{
    padding-left: 50% !important;
}

@media screen and (min-width: 450px){
	#modal-popup{
		width: 100%;
		object-fit: contain;
		height: 680px;
	}
}

</style>
<?php
	$qryPopup = mysql_query("SELECT * 
							   FROM pref_popup 
							  WHERE id_cliente = '$cliente' 
							    AND (data_inicial_publicacao IS NULL 
								 OR data_inicial_publicacao <= CURRENT_DATE())
 							    AND (data_limite IS NULL 
								 OR data_limite >= CURRENT_DATE()) 
								AND status_registro = 'A' ORDER BY id DESC LIMIT 3");

	$lista_popup = array();
	$contador = 0;
	while ($popup = mysql_fetch_assoc($qryPopup)) {
		$confData = true;
  		if (!empty($popup['data_inicial_publicacao']) && !empty($popup['hora_inicial_publicacao']) && $popup['data_inicial_publicacao'] == date("Y-m-d") && $horaInicio > $horaAtual) $confData = false;
  		if (!empty($popup['data_limite']) && !empty($popup['hora_limite']) && $popup['data_limite'] == date("Y-m-d") && $horaLimite < $horaAtual) $confData = false;
 		if (mysql_num_rows($qryPopup) > 0 && $confData == true) {               
    		$lista_popup[$contador] = $popup;
    		$contador++;
  		}
      } ?>
    

    <?php
	if(mysql_num_rows($qryPopup) >= 2){
		$contador_popup = 1;
		foreach ($lista_popup as $valor_popup) {
	?>
    
        <div id="popup-modal_<?= $contador_popup ?>" class="modal fade padding-teste<?=$contador_popup?>" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border: none; box-shadow: none;background: transparent; text-align: center;">
                    <button style="font-size: 35px; color: #fff; opacity: 1; background-color: red; border-radius: 20px; width: 35px; height: 35px; position: absolute; right: 0; z-index: 1;"type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-body" style="padding: 0;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left-right">
                            <a href="<?= $valor_popup['link'] != "" ? $valor_popup['link'] : "#" ?>">
                                <img src="<?= $CAMINHOIMG ?>/<?= $valor_popup['foto'] ?>" class="img-responsive" style="padding-top: 18px; padding-right: 18px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    
  	<?
	  	$contador_popup++;
        }
	}else{
		if(mysql_num_rows($qryPopup) <= 1){
			$contador_popup = 1;
			foreach ($lista_popup as $valor_popup) {
		?>
		
			<div id="popup-modal_<?= $contador_popup ?>" class="modal fade padding-<?=$contador_popup?>" tabindex="-1" role="dialog"  aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content" style="border: none; box-shadow: none;background: transparent; text-align: center;">
						<button style="font-size: 35px; color: #fff; opacity: 1; background-color: red; border-radius: 20px; width: 35px; height: 35px; position: absolute; right: 0; z-index: 1;"type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="modal-body" style="padding: 0;">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left-right">
								<a href="<?= $valor_popup['link'] != "" ? $valor_popup['link'] : "#" ?>">
									<img id="modal-popup" src="<?= $CAMINHOIMG ?>/<?= $valor_popup['foto'] ?>" class="img-responsive" style="padding-top: 18px; padding-right: 18px;">
								</a>
							</div>
						</div>
					</div>
				</div> 
			</div>
		
		  <?
			  $contador_popup++;
			}
		}
	}
?>
