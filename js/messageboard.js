"use strict";
/* messageboard.ts
 * gets all messages and
 * adds them to the page
 */
exports.__esModule = true;
exports.xhrOpen = exports.addPost = void 0;
/* addPost
 * takes the array of messages and appends to the
 * DOM under the messageboard div
 * @param posts - the posts json to append to the DOM
 * @return boolean indicating success
 */
var addPost = function (posts, index, node) {
    for (var _i = 0, _a = posts.reverse(); _i < _a.length; _i++) {
        var p = _a[_i];
        var user = document.createElement('p');
        var username = document.createTextNode(p.username);
        user.appendChild(username);
        user.setAttribute('class', 'messages');
        var message = document.createElement('p');
        var text = document.createTextNode(p.message);
        message.appendChild(text);
        user.appendChild(message);
        node.appendChild(user);
    }
    return true;
};
exports.addPost = addPost;
/* xhrOpen
 * performs the XMLHTTPRequest
 * @param xhr - the XMLHttpRequest object
 * @param url - locating of script to run database fetch
 * must append a GET variable of the messageBoardID
 * @return boolean indicating success
 */
var xhrOpen = function (xhr, url) {
    xhr.open("GET", url);
    xhr.send();
    return true;
};
exports.xhrOpen = xhrOpen;
/* appendNewPost
 * takes a new post to a messageboard
 * and appends to the existing posts
 * @param userID - the userID of the user making the post
 * @param string message - the message to append
 * @return boolean indicating successs
 */
/* export const appendNewPost = (userID:number, message:string) : boolean => {
  console.log("Worked");
  return true;
}

 */
//# sourceMappingURL=messageboard.js.map