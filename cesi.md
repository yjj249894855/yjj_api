FORMAT: 1A

# Example

# AppModulesUserAdminHttpControllersUserController
Class UserController

## 注册用户 [POST /api/user]
使用 `name` 和 `password` 注册用户。

+ Request (application/json)
    + Body

            {
                "name": "foo",
                "password": "bar"
            }

+ Response 200 (application/json)
    + Body

            {
                "id": 10,
                "name": "foo"
            }