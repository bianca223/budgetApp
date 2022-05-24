function getUsersData(){
  const dataToUpdate = getForm("sign_in");
  console.log(dataToUpdate);
  postQuery("API/Controllers/UsersController.php", dataToUpdate, postSuccess, submitFail);
}
function postSuccess(response){
  openMessage("Success", `Ai reusit sa te loghezi! Te-ai autentificat cu succes, ${response['username']}`, "redirect", "index.php");
}
function submitFail(response) {
  openMessage("Fail", `Au aparut urmatoarele erori:  ${response['Error']}`, "close", "noPage");
}