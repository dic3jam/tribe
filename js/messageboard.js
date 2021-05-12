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
var addPost = function (posts, index, node) {
    for (var _i = 0, posts_1 = posts; _i < posts_1.length; _i++) {
        var p = posts_1[_i];
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
    console.log(posts);
    return true;
};
//------functions--------
//-------script----------
var xhr = new XMLHttpRequest();
xhr.open("POST", "../src/get_messages.php");
xhr.send();
xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
        var new_messages = JSON.parse(xhr.response);
        addPost(new_messages, 0, document.getElementById('mb'));
    }
};
//-------script----------
//# sourceMappingURL=messageboard.js.map