app.controller('ListCtrl', function ($scope, dataService) {
    $scope.data = [];
    $scope.count = 0;
    $scope.currentPage = 1;
    $scope.postPerPage = 5;
    $scope.pagesCount = 0;
    $scope.pagesArray = [];

    $scope.updateSource = function() {
        limit = $scope.postPerPage;
        offset = $scope.postPerPage * ($scope.currentPage - 1);
        dataService.getData(limit, offset).then(function(data) {
            $scope.data = data;
        });
    };

    $scope.updateSource();

    dataService.getCount().then(function(count) {
        $scope.count = count;
        $scope.pagesCount = Math.ceil($scope.count / $scope.postPerPage);
        for (var i = 1; i <= $scope.pagesCount; ++i)
            $scope.pagesArray.push(i);
    });

    $scope.delete = function(id) {
        if (confirm('Удалить фото?')) {
            dataService.delete(id).then(function() {
                $scope.updateSource();
            });
        }
    };
});

app.controller('CreateCtrl', function ($scope, $window, dataService, $upload) {
    $scope.photo = {};

    $scope.addPhoto = function(photo, photoForm) {
        var file = photo.file;
        if (photoForm.$valid) {
            dataService.create(photo).then(function(photo){
                if (photo.id) {
                    $upload.upload({
                        url: '/photos/uploads',
                        method: 'POST',
                        data: {
                            photoId: photo.id,
                        },
                        headers: {
                        },
                        file: file
                    }).success(function (data, status, headers, config) {
                        $window.location.href = '/';
                    });
                } else {
                    alert('Error');
                }
            });
        }
    };
});

app.controller('EditCtrl', function ($scope, $window, $routeParams, dataService) {
    $scope.photo = {};
    $scope.tags = '';

    dataService.getItem($routeParams.id).then(function(photo){
        $scope.photo = photo;
        $scope.tags = photo.tagString;
    })

    $scope.updateTags = function(tags) {
        dataService.updateTags($scope.photo.id, $scope.tags);
    };
});
app.controller('SearchCtrl', function ($scope, dataService) {
    $scope.tag = '';
    $scope.data = [];

    $scope.updateSource = function() {
        dataService.getDataByTag($scope.tag).then(function(data) {
            $scope.data = data;
        });
    };

    $scope.delete = function(id) {
        if (confirm('Удалить фото?')) {
            dataService.delete(id).then(function() {
                $scope.updateSource();
            });
        }
    };
});