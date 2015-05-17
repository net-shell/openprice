app.controller('CompetitorsController', function($scope, $rootScope) {
	$scope.selectedStore = null
	$rootScope.initUI()
})

app.controller('StoresController', function($scope, API) {
	API.all('store').getList().then(function(data){ $scope.stores = data })

	$scope.select = function(store) {
		if(store) {
			for(var s in $scope.stores) {
				if(!$scope.stores[s]) continue
				$scope.stores[s].selected = $scope.stores[s] == store
			}
		}
		$scope.$parent.selectedStore = store
	}

	$scope.add = function(){ $('#modalAdd').modal('show') }
})

app.controller('AddController', function($scope, API) {
	$scope.model = {}
	$scope.add = function(){
		API.all('product').post($scope.model).then(function(response) {
			if(response.error) $scope.error = response.error
			else $('#modalAdd').modal('hide')
		})
	}
})

app.controller('ProductsController', function($scope, API, Cassidi) {
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

	function handleSwag(swag, product) {
		if(Object.keys(swag).length) {
			API.one('product', product.id).patch(swag).then($scope.refresh)
		}
	}

	$scope.test = function(product) {
		var t = Cassidi.steal(product.url)
		if(t) t.then(function(S){ handleSwag(S, product) })
	}

	$scope.feartheredbtn = function() {
		if($scope.products.length) {
			Cassidi.queue($scope.products, handleSwag, function(){ alert('Done') })
		}
	}

	$scope.prices = function(product){ $('#modalPrices').modal('show') }
})

app.controller('PricesController', function($scope, API) {
	$scope.chartConfig = {
		options: {
			chart: { zoomType: 'x' },
			rangeSelector: { enabled: true },
			navigator: { enabled: true }
		},
		useHighStocks: true,
		series: $scope.chartSeries,
	}

	API.all('price').post({ products: [57,59] }).then(function(data) {
		console.log(new Array(data))
		$scope.chartConfig.series = data
	});
})