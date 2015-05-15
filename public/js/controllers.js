app.controller('AppController', function ($scope, API) {
	$('.filter.menu .item').tab()
	$('.ui.rating').rating({ clearable: true })
	$('.ui.dropdown').dropdown()
	$('.ui.sidebar').sidebar('attach events', '.launch.button')
	
	$scope.selectedStore = null;
})

app.controller('StoresController', function ($scope, API) {
	API.all('store').getList().then(function(data){ $scope.stores = data })

	$scope.select = function(store){
		if(store) {
			for(var s in $scope.stores) {
				if($scope.stores[s]) $scope.stores[s].selected = $scope.stores[s] == store
			}
		}
		$scope.$parent.selectedStore = store
	}
	
	$scope.add = function(){ $('#add_modal').modal('show') }
})

app.controller('AddController', function ($scope, API) {
	$scope.model = {}
	$scope.add = function(){
		API.all('product').post($scope.model).then(function(response) {
			if(response.error) $scope.error = response.error
			else $('#add_modal').modal('hide')
		})
	}
})

app.controller('ProductsController', function ($scope, API, Cassidi) {
	$scope.refresh = function() {
		if($scope.$parent.selectedStore) {
			API.one('store', $scope.$parent.selectedStore.id).all('products').getList().then(function(data) { $scope.products = data })
		}
	}

	$scope.$parent.$watch('selectedStore', $scope.refresh, true);

	$scope.select = function(product){
		if(product) {
			for(var p in $scope.products) {
				if($scope.products[p]) $scope.products[p].selected = $scope.products[p] == product
			}
		}
		$scope.$parent.selectedProducts = [product]
	}

	// Swag & stuff
	// This object is unique to each store
	var swag = {
		price: {
			selector: '.pricelabel:first',
			callback: function(e){ return parseFloat(e.text()) }
		},
		name: 'h1.brkword'
	}
	
	function handleSwag(swag, product) {
		if(Object.keys(swag).length) {
			API.one('product', product.id).patch(swag)
		}
	}

	$scope.test = function(product) {
		Cassidi.steal(product.url, swag).then(function(S){ handleSwag(S, product) })
	}

	$scope.feartheredbtn = function() {
		if($scope.products.length) {
			Cassidi.queue = $scope.products
			Cassidi.queueIndex = 0
			runQueue()
		}
	}

	function runQueue() {
		if(Cassidi.queueIndex >= Cassidi.queue.length-1) return;
		Cassidi.steal(Cassidi.queue[Cassidi.queueIndex].url, swag).then(function(S){
			handleSwag(S, Cassidi.queue[Cassidi.queueIndex])
			Cassidi.queueIndex++
			runQueue()
		})
	}
})