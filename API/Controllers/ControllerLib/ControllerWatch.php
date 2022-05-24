
  <?php
    function generalGet($conn, $className, $params, $searchParams) {
      if(!$params) {
        return $className::all($conn)->order($searchParams["orderBy"], $searchParams['orderType'])->paginate($searchParams['page'], $searchParams['per_page'])->fetch(); 
      }
      return $className::where($conn, $params)->order($searchParams["orderBy"], $searchParams['orderType'])->paginate($searchParams['page'], $searchParams['per_page'])->fetch();
    }
    function generalLike($conn, $className, $params, $searchParams) {
      if(!$params) {
        return $className::all($conn)->order($searchParams["orderBy"], $searchParams['orderType'])->paginate($searchParams['page'], $searchParams['per_page'])->fetch(); 
      }
      foreach($params as $key => $value) {
        return $className::all($conn)->like($key, $value)->order($searchParams["orderBy"], $searchParams['orderType'])->paginate($searchParams['page'], $searchParams['per_page'])->fetch();
      }
      return NULL;
    }
    function generalGetCount($conn, $className, $params, $searchParams) {
      if(!$params) {
        return $className::all($conn)->count(); 
      }
      return $className::where($conn, $params)->count();
    }
    function generalLikeCount($conn, $className, $params, $searchParams) {
      if(!$params) {
        return $className::all($conn)->count(); 
      }
      foreach($params as $key => $value) {
        return $className::all($conn)->like($key, $value)->count();
      }
      return NULL;
    }
  ?>
