<div class="jumbotron jumbotron-fluid text-center">
	<?php if ($mode=='update'): ?>
    
		  <h1>Mon Profil <?= ($datas->identifiant) ?> ...</h1>
		  <p>Tes amis peuvent te laisser des défi, toutefois tu peux leur donner des idées ou des contraintes.</p>
		  <p>ex: Tu peux interdire tout défi sur ton lieu de travail ou  donner une autre limite de temps par exemple</p> 
    
    <?php else: ?>
		  <h1><?= ($datas->identifiant) ?>, tu souhaites qu'un ami nous rejoigne ? Inscrit le</h1>
		  <p>Son compte ne sera actif qu'après modificaiton de son mot de passe</p> 
		  <p>Ne te trompes pas dans son adresse mail si tu veux qu'il reçoive l'invitation</p> 
    
<?php endif; ?>
</div>
<div class="container-fluid">

	<?php if ($mode=='update'): ?>
    
	<form method="Post" action="/MonProfil/<?= ($datas->numero) ?>" id="formulaire">
    
    <?php else: ?>
	<form method="Post" action="/invite" id="formulaire">
    
<?php endif; ?>
		<div class="form-group row">
		    <label for="staticPseudo" class="col-sm-2 col-form-label">Pseudo</label>
		    <div class="col-sm-10">
		      <input type="hidden" readonly name="numero" value="<?= ($datas->numero) ?>">
		      <input type="text" readonly class="form-control-plaintext" name="Pseudo" id="staticPseudo" value="<?= ($datas->identifiant) ?>">
		    </div>
		  </div>		
		<div class="form-group row">
		    <label for="Nom" class="col-sm-2 col-form-label">Nom</label>
		    <div class="col-sm-10">
		      <input type="text" readonly class="form-control-plaintext" name="Nom" id="Nom" value="<?= ($datas->Nom) ?>">
		    </div>
		  </div>
		<div class="form-group row">
		    <label for="Prenom" class="col-sm-2 col-form-label">Prénom</label>
		    <div class="col-sm-10">
		      <input type="text" readonly class="form-control-plaintext" name="Prenom" id="Prenom" value="<?= ($datas->Prenom) ?>">
		    </div>
		  </div>
		<div class="form-group row">
		    <label for="Email" class="col-sm-2 col-form-label">Email</label>
		    <div class="col-sm-10">
		      <input type="text" readonly class="form-control-plaintext" name="email" id="Email" value="<?= ($datas->email) ?>">
		    </div>
		  </div>
	<?php if ($mode=='update'): ?>
	    
			  <div class="form-group">
			    <label for="conditions">Commentaires général à destination de mes amis</label>
			    <textarea class="form-control form-control-plaintext" id="conditions" name="Conditions" rows="3" maxlength="250"><?= ($datas->Conditions) ?></textarea>
			  </div>
	    
	    <?php else: ?>
			  <div class="form-group">
			    <label for="message">Message d'invitation à transmettre</label>
			    <textarea class="form-control form-control-plaintext" id="message" name="message" rows="3" maxlength="250">Hey, viens on va se faire un super calendrier de l'Avent</textarea>
			  </div>
	    
	<?php endif; ?>
		  <button class="btn btn-primary" id="Save" type="submit">Enregistrer</button>
  	</form>
</div>

	<?php if ($mode=='update'): ?>
    
		<script type="text/javascript" src="/../App/js/profil.update.js"></script>
    
    <?php else: ?>
    	<script type="text/javascript" src="/../App/js/profil.invite.js"></script>
    
<?php endif; ?>
<script type="text/javascript" src="/../App/js/profil.js"></script>