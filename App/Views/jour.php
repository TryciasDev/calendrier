<div class="jumbotron jumbotron-fluid text-center">
  <h1>Aujourd'hui tu as {{count(@datas)}} défis de prévu...</h1>
  <p>Pour chaque défi, tu peux laisser un commentaire à son auteur</p>
  <p>Pour remplir la barre de progression, il te faut cocher la case.</p> 
</div>
<div class="container-fluid">
<repeat group="{{ @datas }}" value="{{ @jour }}" key="{{ @ikey }}">
    <form method="POST">
    	<div class="form-group">
    	<h2>Défi # {{@ikey+1}}, proposé par {{@jour->author}}</h2>
    	<input type="hidden" name="idEvent" value="{{@jour->idEvent}}">
    	<p>{{@jour->description}}</p>
    	<P><label for="Commentaire{{@jour->idEvent}}">Pour laisser un commentaire à {{@jour->author}}</label>

    		<br>
    		<textarea name="commentaire" id="Commentaire{{@jour->idEvent}}"></textarea>
    	</p>
<div class="form-check">
    <input type="checkbox" class="form-check-input" id="isDone{{@jour->idEvent}}" name="isDone">
    <label class="form-check-label" for="isDone{{@jour->idEvent}}">Réalisé ?</label>
  </div>
      	<P>
    		<button type="submit" class="btn btn-primary">Submit</button>
    	</p>
    	</div>
    </form>
<a href="/comment/{{@jour->idEvent}}">cible : {{@jour->target}}</a>
<br>
auteur : {{@jour->author}}
<br>
description : {{@jour->description}}
<br>
isDone : {{@jour->isDone}}
<br>
</repeat>

Ton premier défi du jour est proposé par {{@datas[0]->author}}
</div>
