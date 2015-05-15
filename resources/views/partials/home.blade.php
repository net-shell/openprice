<div class="ui divided two column padded grid" ng-controller="AppController">
	<div class="left column" ng-controller="StoresController">
		<div class="ui left floated launch icon button">
			<i class="sidebar icon"></i>
		</div>
		<div class="ui right floated primary button" ng-click="add()">
			<i class="plus icon"></i> Add Competitor
		</div>
		<div class="ui secondary pointing filter menu">
			<h1 class="ui header item">{{ trans('store.list.title') }}</h1>
			<a class="active red item" data-tab="all">All</a>
			<a class="blue item" data-tab="saved">Saved</a>
		</div>
		<div class="ui active tab" data-tab="all">
			<div class="ui very relaxed animated divided link list">
				<a class="item" ng-class="{ 'active': store.selected }" ng-repeat="store in stores" ng-click="select(store)">
					<img src="http://www.google.com/s2/favicons?domain=@{{ store.domain }}" class="ui top aligned bordered avatar image">
					<div class="content">
						<div class="header">@{{ store.name }}</div>
						@{{ store.updated_at }}
					</div>
				</a>
			</div>
		</div>
		<div class="ui tab" data-tab="saved">
			<div class="ui very relaxed divided link list">
				<a class="item">
					<div class="left floated ui star rating">
						<i class="icon"></i>
					</div>
					<div class="right floated date">Sep 14, 2013</div>
					<div class="description">Your favorite saved article</div>
				</a>
				<a class="item">
					<div class="left floated ui star rating">
						<i class="icon"></i>
					</div>
					<div class="right floated date">Sep 14, 2013</div>
					<div class="description">Your favorite saved article</div>
				</a>
			</div>
		</div>
	</div>
	<div class="right column" ng-controller="ProductsController" ng-show="selectedStore">
			<h2 class="ui header">
				<img src="http://www.google.com/s2/favicons?domain=@{{ selectedStore.domain }}" class="ui bordered circular image">
				<div class="content">
					@{{ selectedStore.name }}
					<div class="sub header">{{ trans('store.products') }}</div>
				</div>
			</h2>

			<div class="ui red icon button" ng-click="feartheredbtn()">
				<i class="lab icon"></i>
				The red button
			</div>

			<div class="ui divider"></div>
			<div class="ui very relaxed link list">
				<div class="item" ng-class="{ 'active': product.selected }" ng-repeat="product in products" ng-click="select(product)">
					<div class="left floated ui primary icon button" ng-click="test(product)">
						<i class="lab icon"></i>
					</div>
					<a class="right floated ui icon button" href="@{{ product.url }}" target="_blank">
						<i class="external icon"></i>
					</a>
					<div class="content">
						<div class="header">
							<a href="@{{ product.url }}" target="_blank">@{{ product.name }}</a>
						</div>
						<p ng-if="product.latest_price">
							<span class="ui green label">
								@{{ product.latest_price.value }}
							</span>
							<span class="ui label">
							@{{ product.latest_price.created_at | asDate | date: 'short' }}
							</span>
						</p>
					</div>
				</div>
			</div>
	</div>
</div>

{{-- Modals --}}

<div id="add_modal" class="ui modal" ng-controller="AddController">
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