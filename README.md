# SocialNetworksBundle
Provides access to the most common operations (including login) for Social Networks


## Sample Configuration

```yaml
social_networks:
  models:
    user: "AppBundle\\Document\\User"
    social_account: "AppBundle\\Document\\SocialAccount"
  web_host: "yourhost.dev"
  platform: "odm" # odm or orm
  networks:
    facebook:
      app_id: "APP_ID"
      app_secret: "APP_SECRET"
    twitter:
      api_key: "API_KEY"
      api_secret: "API_SECRET"
```