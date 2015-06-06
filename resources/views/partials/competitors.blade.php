<div class="ui divided padded grid" ng-controller="CompetitorsController">
	<div class="six wide column" ng-controller="StoresController">
		<header>
			<a class="ui right floated button" ng-click="add()">
				<i class="plus icon"></i> {{ trans('product.add') }}
			</a>
			<div class="header">
				<span class="ui launch icon button">
					<i class="sidebar icon"></i>
				</span>
				{{ trans('store.list.title') }}
			</div>
		</header>
		<div class="ui very relaxed divided link list">
			<a class="item" ng-class="{ 'disabled': store.selected }" ng-repeat="store in stores" ng-click="select(store)">
				<img src="http://www.google.com/s2/favicons?domain=@{{ store.domain }}" class="ui top aligned bordered avatar image">
				<div class="content">
					<div class="header">@{{ store.name }}</div>
					@{{ store.updated_at }}
				</div>
			</a>
		</div>
	</div>

	<div class="ten wide column" ng-controller="ProductsController">
		{{-- Dimmer --}}
		<div class="ui inverted dimmer active" ng-class="{false: 'active', true: 'disabled'}[!loading]">
			<div class="ui text loader">
				<div ng-if="!haiku">please wait :)</div>
				<div ng-repeat="line in haiku">@{{ line }}</div>
			</div>
		</div>

		<div ng-if="!selectedStore">
			<h2 style="clear: left;">
				<i class="left arrow icon"></i>
				Select a Competitor
			</h2>
		</div>

		<div ng-if="selectedStore">
			<h2 class="ui header">
				<img src="http://www.google.com/s2/favicons?domain=@{{ selectedStore.domain }}" class="ui bordered circular image">
				<div class="content">
					@{{ selectedStore.name }}
					<div class="sub header">{{ trans('store.products') }}</div>
				</div>
			</h2>

			<div class="ui orange icon button" ng-click="feartheredbtn()">
				<i class="in cart icon"></i>
				The Red Button
			</div>

			<div class="ui divider"></div>
			<div class="ui very relaxed link list">
				<div class="item" ng-class="{ 'active': product.selected }" ng-repeat="product in products" ng-click="select(product)">
					<div class="left floated ui orange icon button" ng-click="test(product)">
						<i class="in cart icon"></i>
					</div>
					<a class="right floated ui icon button" href="@{{ product.url }}" target="_blank"><i class="external icon"></i></a>
					<div class="right floated ui icon button" ng-click="prices(product)">
						<i class="line chart icon"></i>
					</div>
					<img class="ui avatar bordered image" src="@{{ product.image }}" ng-if="product.image">
					<div class="content">
						<div class="header">
							<a href="@{{ product.url }}" target="_blank">@{{ product.name }}</a>
						</div>
						<p ng-if="product.latest_price">
							<span class="ui label" ng-bind="product.latest_price | price"></span>
							<span am-time-ago="product.latest_price.stored_at"></span>
						</p>
					</div>
				</div>
			</div>
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