# HƯỚNG DẪN SETUP GOOGLE OAUTH CHI TIẾT

## BƯỚC 1: Tạo Google Cloud Project
1. Truy cập: https://console.cloud.google.com/
2. Click "Select a project" → "New Project"
3. Nhập tên project (VD: Camera-Store)
4. Click "Create"

## BƯỚC 2: Bật Google APIs
1. Vào "APIs & Services" → "Library"
2. Tìm và bật các API sau:
   - **Google+ API** (hoặc Google People API)
   - Gmail API (tùy chọn)

## BƯỚC 3: Cấu hình OAuth Consent Screen
1. Vào "APIs & Services" → "OAuth consent screen"
2. Chọn "External" → "Create"
3. Điền thông tin:
   - App name: **Camera Store**
   - User support email: **email của bạn**
   - Developer contact: **email của bạn**
4. Click "Save and Continue" qua các bước

## BƯỚC 4: Tạo OAuth 2.0 Credentials
1. Vào "APIs & Services" → "Credentials"
2. Click "+ Create Credentials" → "OAuth client ID"
3. Application type: **Web application**
4. Name: **Camera Store Web Client**
5. Authorized redirect URIs:
   ```
   http://localhost:8000/auth/google/callback
   http://127.0.0.1:8000/auth/google/callback
   ```
6. Click "Create"

## BƯỚC 5: Copy Credentials
1. Copy "Client ID" và "Client secret"
2. Thêm vào file `.env`:
   ```
   GOOGLE_CLIENT_ID=your_client_id_here
   GOOGLE_CLIENT_SECRET=your_client_secret_here
   GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
   ```

## BƯỚC 6: Chạy Migration
```bash
php artisan migrate
```

## BƯỚC 7: Test
1. Chạy: `php artisan serve`
2. Truy cập: http://localhost:8000/login
3. Click nút "Đăng nhập bằng Google"

## LƯU Ý:
- Đảm bảo domain trong redirect URI khớp với domain bạn đang chạy
- Nếu deploy lên server, cần thêm domain production vào redirect URIs
- Google có thể yêu cầu verify domain cho production