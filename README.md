# API AI Helper

API AI Helper is a Laravel-based API that provides AI-powered features for content generation, question answering, and post management. It integrates with both Google's Gemini and OpenAI services to provide flexible AI capabilities.

## Features

### 1. Post Management API
Manage blog posts and articles with a full CRUD API:
- Create, read, update, and delete posts
- User authentication to ensure posts belong to the correct user
- Pagination support for efficient data handling

### 2. AI-Powered Question Answering
Intelligent question answering system that supports:
- Natural language processing for complex questions
- Integration with both Google Gemini and OpenAI models
- Automatic saving of question-answer history per user
- Choice of local or cloud-based processing

### 3. Image-Based Prompt Generation
Advanced image analysis and prompt extraction:
- Upload images to generate descriptive prompts
- Support for various image formats
- AI-powered content recognition and description
- Option to use either Google Gemini or OpenAI models
- Automatic file handling and storage

## API Endpoints

### Authentication
- `GET /api/user` - Retrieve authenticated user information

### Posts
- `GET /api/v1/posts` - Get paginated list of user's posts
- `POST /api/v1/posts` - Create a new post
- `GET /api/v1/posts/{id}` - Get a specific post
- `PUT /api/v1/posts/{id}` - Update a post
- `DELETE /api/v1/posts/{id}` - Delete a post

### Question Answering
- `GET /api/v1/questions` - Get list of user's question-answer pairs
- `POST /api/v1/questions` - Submit a question and receive an answer
- Supports both local and cloud-based AI models

### Prompt Generation
- `GET /api/v1/prompt-generations` - Get user's prompt generation history with filtering and sorting options
- `POST /api/v1/prompt-generations` - Upload an image and generate a descriptive prompt
- Includes search, sort, and pagination parameters

## Technologies Used

- Laravel 11+
- Google Gemini API
- OpenAI API
- Laravel Sanctum for API authentication
- Laravel Resource classes for structured API responses
- Image processing and content extraction

## Setup Instructions

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/api-ai-helper.git
   cd api-ai-helper
   ```

2. Install dependencies:
   ```
   composer install
   npm install
   ```

3. Configure environment:
   ```
   cp .env.example .env
   php artisan key:generate
   ```

4. Set up your API keys in the `.env` file:
   ```
   GEMINI_API_KEY=your_gemini_api_key
   OPENAI_API_KEY=your_openai_api_key
   ```

5. Run migrations:
   ```
   php artisan migrate
   ```

6. Start the development server:
   ```
   php artisan serve
   ```

## Authentication

All API requests (except authentication endpoints) require an API token. Obtain your token by registering or logging in via the authentication endpoints at `/api/login` and `/api/register`.

Include your API token in the Authorization header of each request:
```
Authorization: Bearer YOUR_API_TOKEN
```

## Security Features

- Rate limiting to prevent API abuse
- User isolation - users can only access their own data
- File upload validation and sanitization
- Input validation and sanitization

## Contributing

We welcome contributions! Please follow these steps:
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open source and available under the MIT License.

## Support

If you encounter any issues or have questions, please file an issue on the GitHub repository.