<h2>Strona główna</h2>
<form method="get" action="/search.php" class="yform columnar">
	<fieldset>
		<legend>Wyszukiwarka</legend>
			
			<div class="type-text">
				<label for="keyword">Słowo kluczowe:</label>
				<input id="keyword" type="text" name="keyword" />
			</div>
			
			<div class="type-select">
				<label for="author">Autor: </label>
				<select id="author" name="author_id">
					<option value="">wybierz</option>
				</select>
			</div>

			<div class="type-select">
				<label for="category">Kategoria: </label>
				<select id="category" name="category_id">
					<option value="">wybierz</option>
				</select>
			</div>

			<div class="type-select">
				<label for="sort">Sortowanie według: </label>
				<select id="sort" name="order">
					<option value="date_a" >daty &#9650;</option>
					<option value="date_d" >daty &#9660;</option>
					<option value="author_a">autora &#9650;</option>
					<option value="author_d">autora &#9660;</option>
					<option value="category_a">kategorii &#9650;</option>
					<option value="category_d">kategorii &#9660;</option>
				</select>
			</div>
			
			<div class="type-button">
				<input type="submit" value="Szukaj" />
			</div>
			
	</fieldset>
</form>