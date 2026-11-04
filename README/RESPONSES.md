1. Index Listing ( index )

Route & Method: GET /users

Success : Fetches and displays the paginated users list ( users.index ).
Applies search filters (by name, email, or phone) and status filters ( Active vs Banned ).
Persists filter queries during page transitions using withQueryString() .

Failure : If invalid query parameters are supplied via the URL (e.g., index=999 or status=invalid ), the controller ignores them and falls back to standard default values ( index = 10 ).

2. Store User ( store )

Route & Method: POST /users

Success : Persists the newly created user record in the database.
Redirects to the index route ( users.index ).
Displays a flash message: "User {name} created successfully."

Failure : Halts execution if UserRequest validation fails.
Redirects back to the create form ( users.create ).
Preserves form inputs using old() and displays field specific validation errors inline.

3. Show User Details ( show )

Route & Method: GET /users/{id}

Success : Retrieves and renders the detailed user profile card ( users.show ).

Failure : If the specified $id does not exist in the database,
returns an explicit 404 status code and renders the custom error view ( users.err404 ).

4. Edit User Form ( edit )

Route & Method: GET /users/{c_user}/edit

Success : Fetches the model via Route Model Binding and renders the pre filled edit form ( users.edit ).

Failure : If the requested c_user ID is missing or invalid,
Laravel automatically yields a standard 404 Not Found response.

5. Update User ( update )

Route & Method: PUT /users/{c_user}

Success : Updates the user attributes in the database (hashes new password if provided; preserves old password if left blank).
Redirects to (users.index) .
Displays a flash message: "User {name} updated successfully."

Failure : If UserRequest validation fails,
redirects back to the edit form. Preserves inputs and displays validation errors inline.

6. Delete User ( destroy )

Route & Method: DELETE /users/{id}

Success : Removes the user record from the database.
Redirects to users.index .
Displays a flash message: "User \"{name}\" deleted successfully."

Failure : If $id is not found ( findOrFail ), returns a 404 Not Found page.
If a database/server exception occurs during deletion, catches the exception and redirects to users.index with an error message: "Failed to delete user: {error_message}" .

7. Show Ban Form ( showBanForm )

Route & Method: GET /users/{c_user}/ban form

Success : Displays the ban confirmation view containing the reason input field
and user summary ( users.ban ).

Failure / Guard : If the user is already banned ( is_banned == true ), prevents access and redirects directly back to users.index .

8. Ban User ( ban )

Route & Method: POST /users/{c_user}/ban

Success : Sets is_banned to true and records the provided ban_reason . Redirects to users.index . Displays a flash message: "User {name} has been banned successfully."

Failure : If ban_reason is missing or exceeds 500 characters, returns to the ban form with a validation error message.

9. Unban User ( unban )

Route & Method: POST /users/{c_user}/unban

Success : Resets is_banned to false and clears ban_reason and banned_at to null . Redirects to users.index . Displays a flash message: "User {name} has been unbanned successfully."

Failure : If the target user record is not found in the database, returns a 404 Not Found response.
