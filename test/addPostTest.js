var addPost = function (posts, index, node) {
  if (index == (Object.keys(posts)).length)
      return true;
  var user = document.createElement('p');
  var username = document.createTextNode(posts[index].username);
  user.appendChild(username);
  var message = document.createElement('p');
  var text = document.createTextNode(posts[index].message);
  message.appendChild(text);
  user.appendChild(message);
  node.appendChild(user);
  addPost(posts, index++, message);
  //console.log(posts);		  
};

var posts = [
  {
    "name":"Jim",
    "age":29
  },
  {
    "name":"Hope",
    "age":27
  }
]

addPost(posts, 0, null);