<div class="ui two column padded grid" ng-controller="RelationsController">
	<div class="column" ng-controller="MyStoresController">
		<header>
			<a class="ui right floated button" ng-click="add()">
				<i class="plus icon"></i> {{ trans('product.add') }}
			</a>
			<div class="header">
				<span class="ui launch icon button">
					<i class="sidebar icon"></i>
				</span>
				{{ trans('store.my.title') }}
			</div>
		</header>

		<h2 ng-if="!products">
			{{ trans('store.choose') }}
			<i class="ui arrow down icon"></i>
		</h2>
		
		<div class="ui fluid store selection dropdown">
			<div class="default text">Select Store</div>
			<div class="menu">
				<div class="item" ng-class="{ 'active': store == $parent.selectedStore }" ng-repeat="store in stores" ng-click="select(store)">
					<img src="http://www.google.com/s2/favicons?domain=@{{ store.domain }}" class="ui top aligned bordered avatar image">
					@{{ store.name }}
				</div>
			</div>
		</div>
		<div ng-if="products">
			<div class="ui padded grid">
				<div class="column">
					<div class="ui fluid icon input" ng-class="{ 'loading': loading }">
						<input type="text" ng-model="$parent.my.search" placeholder="{{ trans('app.search') }}">
						<i class="search icon"></i>
					</div>
				</div>
			</div>
			<div class="ui header centered" ng-if="!products.length">
				{{ trans('products.empty') }}
			</div>
			<div class="ui three column padded grid">
				<div class="column" ng-repeat="product in products">
					<div class="ui card" ng-click="selectedProduct = product">
						<div class="image">
							<img src="@{{ product.image }}">
						</div>
						<div class="content">
							<div class="header">
								<span class="left">@{{ product.name }}</span>
								<span class="ui right label">@{{ product | price }}</span>
							</div>
							<div class="meta" am-time-ago="product.latest_price.stored_at"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="column">
		<div ng-if="selectedProduct">
			<div class="ui card">
				<div class="image">
					<img src="@{{ selectedProduct.image }}">
				</div>
				<div class="content">
					<div class="header">
						<span class="left">@{{ selectedProduct.name }}</span>
						<span class="ui right label">@{{ selectedProduct.latest_price.value }}</span>
					</div>
					<div class="meta" am-time-ago="selectedProduct.latest_price.stored_at"></div>
				</div>
			</div>
		</div>
		<div ng-controller="ProductsController">
		</div>
	</div>
</div>

{{-- Add Product Modal --}}

<div id="modalAdd" class="ui modal" ng-controller="AddController">
	<i class="close icon"></i>
	<div class="header">
		{{ trans('add competitor product') }}
	</div>
	<div class="content">
		<div class="image">
			<i class="world icon"></i>
		</div>
		<div class="description">
			<div class="ui form" ng-class="{ 'error': error }">
				<div class="ui error message">@{{ error }}</div>
				<div class="field">
					<label>{{ trans('competitor.url') }}</label>
					<div class="ui fluid icon input" ng-class="{ 'loading': loading }">
						<i class="external icon"></i>
						<input type="text" placeholder="http://site.com/product.html" ng-model="model.url">
					</div>
				</div>
				<div class="field">
					<div class="ui positive fluid labeled icon button" ng-click="add()">
						<i class="checkmark icon"></i>
						Add
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- Price History Modal --}}

<div id="modalPrices" class="ui modal" ng-controller="PricesController">
	<i class="close icon"></i>
	<div class="content">
		<highchart id="prices_chart" config="chartConfig" style="width: 950px;"></highchart>
	</div>
</div>