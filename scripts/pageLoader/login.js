function getUsersData(){
  const dataToUpdate = getForm("log_in");
  postQuery("API/Controllers/UsersController.php?logare=true", dataToUpdate, postSuccess, submitFail);
}
function postSuccess(response){
  openMessage("Success", `Ai reusit sa te loghezi! Bine ai revenit, ${response['username']}`, "redirect", "index.php");
}
function submitFail(response) {
  openMessage("Fail", `Au aparut urmatoarele erori: ${response['Error']}`, "close", "noPage");
}