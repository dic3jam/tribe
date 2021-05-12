/* messageboard.ts
 * gets all messages and 
 * adds them to the page
 */

//------functions--------

/* addPost
 * takes the array of messages and appends to the 
 * DOM under the messageboard div
 * @param posts - the posts json to append to the DOM 
 * @return boolean indicating success
 */
const addPost = (posts, index:number, node:Element) : boolean  => {
  for(const p of posts) {
    let user:Element = document.createElement('p');
    let username:Node = document.createTextNode(p.username);
    user.appendChild(username);
    user.setAttribute('class', 'messages');
    let message:Element = document.createElement('p');
    let text:Node = document.createTextNode(p.message);
    message.appendChild(text);
    user.appendChild(message);
    node.appendChild(user);
  }
  console.log(posts);		  
  return true;
}

//------functions--------
//-------script----------

let xhr = new XMLHttpRequest();
xhr.open("POST", "../src/get_messages.php");
xhr.send();
xhr.onreadystatechange = function() {
  if (xhr.readyState == 4) {
    let new_messages = JSON.parse(xhr.response);
    addPost(new_messages, 0, document.getElementById('mb'));
  }
};

//-------script----------



