# Membership Registration and Approval

## Workflow

1. A visitor submits a membership application with account credentials, a 16-digit NIK, birth details, contact details, address, and an optional profile photo.
2. The application creates a `users` record with `role=member` and `account_status=pending`, plus a `membership_applications` record with `status=pending_review`.
3. The applicant receives a registration number and a random secret access token. The token is shown once after submission; only its SHA-256 hash is stored.
4. The applicant can track status using both values. The tracking endpoint is rate-limited and does not reveal identity data.
5. Admins can approve, request revisions, or reject applications. Approval creates the existing `members` record and activates the account in one database transaction. A revision request keeps the account restricted. Rejection suspends the account.
6. Approved members use the existing member profile, digital card, and public QR verification features.

## Status fields

- `users.account_status`: `active`, `pending`, or `suspended`. Existing accounts default to `active`.
- `membership_applications.status`: `pending_review`, `needs_revision`, `approved`, or `rejected`.
- `members.status` remains the existing membership status (`active` or `inactive`) and is not used as the application review state.

## NIK protection

NIK values in `members.nik` and `membership_applications.nik` are encrypted with Laravel's encrypted cast / application encrypter. Duplicate checks use a separate HMAC fingerprint stored in `nik_hash`; plaintext NIK is not used for database equality queries.

**Before deploying the migration to an existing database:**

- Take and verify a database backup.
- Ensure `APP_KEY` is configured and back it up securely.
- Keep the same application key available for decryption and fingerprint checks. Rotating it without a planned re-encryption and fingerprint migration will make existing encrypted NIK values unreadable and duplicate lookups inconsistent.
- Test the migration and rollback on a recent database copy before production deployment.

The migration converts existing member NIK values to encrypted storage. Rollback decrypts them using the same `APP_KEY`; it must not be run after key rotation.

## Operational notes

- Do not log the access token or store it in plaintext.
- If an applicant loses the token, do not expose the stored hash. Use a separate authenticated recovery flow rather than attempting to recover the original token.
- Reviewers should include a clear note when requesting revisions so applicants know what to correct.
- The approval workflow must stay transactional so an account cannot become active without a corresponding member record.
