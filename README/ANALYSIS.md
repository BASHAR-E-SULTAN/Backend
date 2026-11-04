1. Client & Problems

Client: Reem.
Problems Faced:  
 Accidental Deletion Issue: Reem was accidentally deleting users due to the lack of a confirmation prompt before deletion operations.
Confusing Responses & Duplicate Submissions: Reem suffered from uncertainty about whether data was saved or not due to missing feedback and success/error indicators.
Blank Pages & Confusing Errors: Occurrence of unhandled exception screens instead of a clean, dedicated error interface like err404 .
Form Data Loss on Error: Loss of user input inside forms whenever validation failed.

2.  Saved Data & Types

User data is stored in the user table with the following column types and constraints:

Required Fields:

- id : Auto-incrementing identifier ( bigint , Primary Key).
- name : User's name ( string with a maximum limit of 50 characters , varchar(50) ).
- email : User's email address ( string with a maximum limit of 100 characters , varchar(100) Unique).
- phone : User's phone number ( string with a maximum limit of 20 characters , varchar(20) Unique).
- password : Encrypted password string ( varchar(255) ).
- is_banned : Ban status flag ( boolean defaulting to false ).
- created_at / updated_at : Automatic creation and update timestamps ( timestamp ).

Optional Fields (Nullable):

- ban_reason : Reason for banning the user ( string with a maximum limit of 250 characters , null if the user is active).
- banned_at : Date and time when the ban occurred ( timestamp , null if the user is active).

3.  Non-Negotiable Rules

Unique Field Protection: Email and phone numbers are protected via validation rules and database constraints. During updates, the current user ID is excluded using ignore() to avoid false "already taken" validation errors.
Password Protection: Passwords are hashed immediately upon receiving requests and hidden from model arrays ( $hidden ). During updates, the password field is optional; leaving it blank preserves the existing password.
Ban and Unban Logic: Banning requires entering a valid reason and automatically captures the timestamp. Unbanning resets is_banned to false and clears both ban_reason and banned_at to null .
Filtering & Pagination Persistence: Query parameters ( page , status , search , index ) are validated and persisted across page navigations using withQueryString() .

4.  Routes & Actions Table

| Action        | Method | Route Path              | Success Behavior & Message                                                   | Failure Behavior & Message                                              |
| :------------ | :----: | :---------------------- | :--------------------------------------------------------------------------- | :---------------------------------------------------------------------- |
| Index List    |  GET   | users/                  | Displays users list with filtering and pagination                            | Ignores invalid query parameters and applies defaults                   |
| Create Form   |  GET   | users/create/           | Displays the create user interface                                           | nothing                                                                 |
| Store User    |  POST  | users/                  | Redirects to index + unified success message                                 | Returns to form + preserves input + shows validation errors inline      |
| Show Details  |  GET   | users/{id}/             | Displays the user details card                                               | Displays unified user not found page ( err404 )                         |
| Edit Form     |  GET   | users/{c_user}/edit/    | Displays edit interface pre-filled with current user data                    | Displays unified user not found page ( err404 )                         |
| Update User   |  PUT   | users/{c_user}/         | Redirects to index + unified success message                                 | Returns to form + shows validation errors inline                        |
| Delete User   | DELETE | users/{id}/             | Deletes record + redirects to index + success message                        | Displays unified user not found page ( err404 )                         |
| Show Ban Form |  GET   | users/{c_user}/ban-form | Displays ban reason form and user profile card                               | Redirects to index or error page if user is already banned              |
| Ban User      |  POST  | users/{c_user}/ban      | Updates status, timestamp, and reason + redirects to index + success message | Returns with validation error if ban reason is omitted                  |
| Unban User    |  POST  | users/{c_user}/unban    | Resets ban data, sets user Active + redirects to index + success message     | Displays unified user not found page ( err404 ) or appropriate redirect |

5.  Edge Cases & Ambiguities

Can the password field be left blank during an update?  
 Yes. If Reem leaves the password field empty during an update, the user's existing hashed password is retained unchanged.

What is the maximum limit for items per page?  
 The pagination index parameter is constrained to a maximum of 20 items per page to prevent memory overflow and reduce database load.

Does unbanning require a reason or confirmation?  
 Unbanning does not require a reason, but a quick confirmation popup alert is triggered before executing to prevent accidental unbanning.

Does a banned user get prevented from logging in?  
 The system currently does not include an authentication/login layer, but banned users are visually highlighted (red row background) and prevented from active status operations.
