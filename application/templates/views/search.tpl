<h2>Wyszukiwarka</h2>
	{if $search.values.submit && !$search.results}
		<p class="warning">
				Nie znaleziono artykułów spełniających podane kryteria
		</p>
	{/if}
	<form method="get" action="/search.php" class="yform columnar">
		<fieldset>
			<legend>Wyszukiwarka</legend>

			<div class="type-text">
				<label for="keyword">Słowo kluczowe:</label>
				<input id="keyword" type="text" name="keyword" value="{$search.values.keyword|escape:'html'|default:''}" />
			</div>

			<div class="type-select">
				<label for="author">Autor: </label>
				<select id="author" name="author_id">
					<option value="">wybierz</option>
					{foreach from=$search.options.authors item=author name=list_author}
					<option value="{$author.author_id}"{if $author.author_id == $search.values.author_id} selected="selected"{/if}>{$author.name|escape}</option>
					{/foreach}
				</select>
			</div>

			<div class="type-select">
				<label for="category">Kategoria: </label>
				<select id="category" name="category_id">
					<option value="">wybierz</option>
					{foreach from=$search.options.category item=category name=list_category}
					<option value="{$category.category_id}"{if $category.category_id == $search.values.category_id} selected="selected"{/if}>{$category.name|escape}</option>
					{/foreach}
				</select>
			</div>

			<div class="type-select">
				<label for="sort">Sortowanie według: </label>
				<select id="sort" name="order">
					<option value="date_a"{if 'date_a' == $search.values.order} selected="selected"{/if}>daty &#9650;</option>
					<option value="date_d"{if 'date_d' == $search.values.order} selected="selected"{/if}>daty &#9660;</option>
					<option value="author_a"{if 'author_a' == $search.values.order} selected="selected"{/if}>autora &#9650;</option>
					<option value="author_d"{if 'author_d' == $search.values.order} selected="selected"{/if}>autora &#9660;</option>
				</select>
			</div>

			<div class="type-button">
				<input type="submit" value="Szukaj" />
				<input type="reset" value="Wyczyść formularz" class="" id="reset" />
			</div>

		</fieldset>
	</form>
	<script type="text/javascript">
		/* {literal} */
		var reset = document.getElementById('reset');
		var potwierdzenie = function() {
			if(confirm('Czy na pewno chcesz wyczyścić formularz? Wprowadzone dane zostaną usunięte.')) {
				window.location = '/search.php';
				return true;
			}
			return false;
		};
		reset.onClick = potwierdzenie;
		reset.onclick = potwierdzenie;
		/* {/literal} */
	</script>

	{if $search.values.submit && $search.results}
		<h3>Wyniki wyszukiwania</h3>

		<table border="0" cellpadding="0" cellspacing="0" class="full">
			<caption>

			</caption>
			<thead>
				<tr>
					<th scope="col">Data </th>
					<th scope="col">Tytuł</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th scope="col">Data </th>
					<th scope="col">Tytuł</th>
				</tr>
			</tfoot>
			<tbody>
				{foreach from=$search.results item=result name=list_results}
				<tr>
					<th scope="col"{if $smarty.foreach.list_results.iteration%2 eq 0} class="sub"{/if}>{$result->create_date|date_format:'%e-%m-%Y godz. %H:%M'}</th>
					<th scope="col"{if $smarty.foreach.list_results.iteration%2 eq 0} class="sub"{/if}><a href="/article.php?id={$result->article_id}">{$result->title|escape}</a></th>
				</tr>
				{/foreach}
			</tbody>
		</table>
		{if 1 < $search.pagination.found_records}
			<div class="pagination">
				<ul>
					<li>
						<a href="?{$search.pagination.query_string}&amp;page=1" title="Strona pierwsza">
							&laquo; pierwsza
						</a>
					</li>
					{section start=0 loop=$search.pagination.found_records name=paginator}
						{if $search.pagination.page_active != $smarty.section.paginator.iteration}
							<li>
								<a href="?{$search.pagination.query_string}&amp;page={$smarty.section.paginator.iteration}" title="Strona {$smarty.section.paginator.iteration}">
									{$smarty.section.paginator.iteration}
								</a>
							</li>
						{else}
							<li class="selected">
								<span>
									{$smarty.section.paginator.iteration}
								</span>
							</li>
						{/if}
					{/section}
					<li>
						<a href="?{$search.pagination.query_string}&amp;page={$search.pagination.found_records}" title="Strona ostatnia">
							ostatnia &raquo;
						</a>
					</li>
				</ul>
			</div>
		{/if}
{/if}