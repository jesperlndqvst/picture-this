# picture-this
School assignment at YRGO. Create an Instagram clone using PHP, SQL, HTML, CSS and JavaScript.

## User stories

#### Minimum

- [x]  As a user I should be able to create an account.

- [x]  As a user I should be able to login.

- [x]  As a user I should be able to logout.

- [x]  As a user I should be able to edit my account email, password and biography.

- [x]  As a user I should be able to upload a profile avatar image.

- [x]  As a user I should be able to create new posts with image and description.

- [x]  As a user I should be able to edit my posts.

- [x]  As a user I should be able to delete my posts.

- [x]  As a user I should be able to like posts.

- [x]  As a user I should be able to remove likes from posts.

#### Extras: 

- [x] As a user I should be able to follow and unfollow other users.

- [x] As a user I should be able to view a list of posts by users I follow.

- [x] As a user I should be able to search for users.

- [x] As a user I'm able to comment on a post.

- [x] As a user I'm able to edit my comments.

- [x] As a user I'm able to delete my comments.

## Requirements

- [x] The project should implement nice looking graphical user interface.

- [x] The application should be written in HTML, CSS, JavaScript and PHP.

- [x] The application should be built using a SQLite database with at least three different tables.

- [x] The application should be responsive and be built using the method mobile-first.

- [x] The application should be implement secure hashed passwords when signing up.

- [x] The project's PHP files should declare strict types
    > **Note:** Strict types should only be declared in files that just contains PHP.

- [x] The project can't contain any PHP errors, warning or notices.

- [x] The project must be tested on at least two of your classmates computers.

## How to use it

1. Clone this repository to your directory through the terminal.
```
$ git clone https://github.com/jesperlndqvst/picture-this.git
```
2. Change current directory to the cloned repo.
```
$ cd picture-this/public
```
3. Start your web server (8000 can be changed to any other 4 digits, ex. 1337 also works).
```
$ php -S localhost:8000
```

## Preview
<img src="https://i.imgur.com/i1SRj8C.png" width="33%" /> <img src="https://i.imgur.com/3xoXMre.png" width="33%" /> <img src="https://i.imgur.com/C0OsGZy.png" width="33%">

## Testers
* [Daniel Thorsen](https://github.com/DanThor)
* [Betsy Alva Soplin](https://github.com/milliebase)
* [Mikaela Lundsgård](https://github.com/mikaelaalu)

## Code Review

* register.php#40-44 insted of using bind param you could use execute and to bind multiple variables.
* index.php#23-30 You could break out the error part into a view and require it in to reduce duplication.
* main.js#11-17 you could choose diffrent names for classes fas / far to something more descriptive.
* main.js maybe break up main.js into separate files to easier find the dunction your after.
* index.php#5 you could set a variable in autoload for $user_id = $_SESSION['user']['id'] if it is set since its used quite a bit.
* functions.php Great job on breaking up alot of php into functions.
* functions.php The naming of your functions made it very easy to understand what they did.
* main.js#12-18 you could use heart.classList.replace(fas,far) instead of first removing then adding.
* settings.php#12-14 good job on breaking out sanitize into functions.
* gitignore# you have ignored the uploads posts folder so it didnt exist when i cloned your repo. you could write public/app/uploads/avatars/* and public/app/uploads/posts/* and use gitkeep instead. 

Code review by: [Erik Johanesson](https://github.com/Erik-joh)

## Contribution

- [x] Update search function to perform a live search on keydown.

> **Note:** It should update first after user has entered three keys.

- [x] As a user I'm able to delete my account along with all posts and comments etc.

Pull request by: [Erik Johanesson](https://github.com/jesperlndqvst/picture-this/pull/58)

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
