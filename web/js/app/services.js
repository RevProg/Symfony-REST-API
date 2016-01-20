app.factory('dataService', function($http, $q){
    return {
        getData: function (limit, offset) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/photos',
                params: {
                    limit: limit,
                    offset: offset,
                },
            }).
            success(function (data, status, headers, config) {
                deferred.resolve(data);
            }).
            error(function (data, status, headers, config) {
                deferred.reject(status);
            });
            return deferred.promise;
        },
        getDataByTag: function (tag) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/photos/tag',
                params: {
                    tag: tag,
                },
            }).
            success(function (data, status, headers, config) {
                deferred.resolve(data);
            }).
            error(function (data, status, headers, config) {
                deferred.reject(status);
            });
            return deferred.promise;
        },
        getItem: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/photos/' + id
            }).
            success(function (data, status, headers, config) {
                deferred.resolve(data);
            }).
            error(function (data, status, headers, config) {
                deferred.reject(status);
            });
            return deferred.promise;
        },
        getCount: function () {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: '/photos/count'
            }).
            success(function (data, status, headers, config) {
                deferred.resolve(data);
            }).
            error(function (data, status, headers, config) {
                deferred.reject(status);
            });
            return deferred.promise;
        },
        create: function (photo) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: '/photos',
                data: {photo: { title: photo.title}, tags: photo.tags },
                headers: {
                }
            }).
            success(function (data, status, headers, config) {
                deferred.resolve(data);
            }).
            error(function (data, status, headers, config) {
                deferred.reject(status);
            });
            return deferred.promise;
        },
        updateTags: function (id, tags) {
            var deferred = $q.defer();
            $http({
                method: 'PUT',
                url: '/photo/tags',
                data: {
                    id: id,
                    tags: tags
                },
                headers: {
                }
            }).
            success(function (data, status, headers, config) {
                deferred.resolve(data);
            }).
            error(function (data, status, headers, config) {
                deferred.reject(status);
            });
            return deferred.promise;
        },
        delete: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'DELETE',
                url: '/photos/'+id,
                headers: {
                    //'Content-type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Needed by Yii to look at it as ajax request.
                }
            }).
            success(function (data, status, headers, config) {
                deferred.resolve(data);
            }).
            error(function (data, status, headers, config) {
                deferred.reject(status);
            });
            return deferred.promise;
        },
    }
});