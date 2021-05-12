/* messageboard.ts
 * gets all messages and 
 * adds them to the page
 */

/* addPost
 * takes the array of messages and appends to the 
 * DOM under the messageboard div
 * @param posts - the posts json to append to the DOM 
 * @return boolean indicating success
 */
export const addPost = (posts, index:number, node:Element) : boolean  => {
  for(const p of posts.reverse()) {
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
  return true;
}

/* xhrOpen
 * performs the XMLHTTPRequest
 * @param xhr - the XMLHttpRequest object
 * @param url - locating of script to run database fetch
 * must append a GET variable of the messageBoardID
 * @return boolean indicating success
 */
export const xhrOpen = (xhr:XMLHttpRequest, url:string) : boolean => {
  xhr.open("GET", url);
  xhr.send();
  return true;
}


