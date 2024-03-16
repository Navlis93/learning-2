<h1>Todo-лист</h1>
<form method="post">
	<input type="text" name="new-element">
	<?= $error ? '<div style="color:red;">'.$error.'</div>' : '' ?>
	<div>
		<button type="submit">Добавить</button>
	</div>
</form>
<ul>
	<?php 
	foreach ($items as $item) {
		echo '<li '. ($item['status'] == 1 ? 'class="text-through"' : '') .'>'.$item['text'].'<span class="complete-item" data-id="'.$item['id'].'">✓</span> <span class="remove-item" data-id="'.$item['id'].'">X</span></li>';
	}
	
	?>
</ul>

<script>
	document.querySelectorAll('.remove-item').forEach(function(elem) {
		elem.addEventListener('click', async function () {
			let response = await fetch('/remove', {
			  method: 'POST',
			  headers: {
			    'Content-Type': 'application/json'
			  },
			  body: JSON.stringify({"id": event.target.closest('.remove-item').getAttribute('data-id')})
			});
			let result = await response.json();
			if (result.success) {
				window.location.reload();
			}
			
		})
	});

	document.addEventListener('click', async function(event){
		if (event.target.closest('.complete-item')) {
			let response = await fetch('/complete', {
			  method: 'POST',
			  headers: {
			    'Content-Type': 'application/json'
			  },
			  body: JSON.stringify({"id": event.target.closest('.complete-item').getAttribute('data-id')})
			});
			let result = await response.json();
			if (result.success) {
				window.location.reload();
			}
		}
	});

</script>