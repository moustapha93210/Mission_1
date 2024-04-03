<div id="contenu">
      <h2>Mes fiches de frais</h2>
      <h3>Id et Type à sélectionner : </h3>
  <form action="index.php?uc=idvisiteurType&action=voirIdType" method="post">
          <div class="corpsForm">
            
          <p>
      
            <label for="lstIdv" accesskey="n"> Id visiteur : </label>

              <select id="lstIdv" name="lstIdv">

                <?php
                
                    foreach ($lesIdv as $unIdv)
                    {

                ?>
                    <option selected value="<?php echo $unIdv['id'] ?>"><?php echo  $unIdv['id'] ?> </option>

                <?php 
    
                    }
                  
                ?>    
                  
              </select>

            <label for="lstType" accesskey="n">Type de frais : </label>
              <select id="lstType" name="lstType">

                <?php
                foreach ($lesTypes as $unType)

                {
                
                ?>

                  <option value="<?php echo $unType['id'] ?>"><?php echo  $unType['id']?> </option>

                <?php 

                
                }
                    
                ?>    
                  
              </select>
          </p>

      </div>

      <div class="piedForm">

        <p>
          <input id="ok" type="submit" value="Valider" size="20" />
          <input id="annuler" type="reset" value="Effacer" size="20" />
        </p> 
      </div>
        
  </form>

    <br>