```
 - docker exec -ti graphqlite-php sh
 - bin/console d:m:m
 - bin/console d:f:l
 - bin/console l:e:s
 - http://0.0.0.0:8001/graphiql
 - profit
```

## Available queries

### Get Epg Events
```
query EpgEvents{
  epgEvents(
    date: "2020-08-30",
    timezone: "+02:00"
    channelId: "877107fe-e359-45dc-b803-9433761952e3", 
  ) {
    	id
      name
      start
      end
      channel {
        id
        externalId
        externalName
        name
    	}
   }
}
```

### Get Channel Playback Link
```
query ChannelPlayback($channelId: ID!, $profileId: ID!, $channelPlaybackInput: ChannelPlaybackInput!) {
  channelPlayback(channelId: $channelId, profileId: $profileId, channelPlaybackInput: $channelPlaybackInput) {
     watchingStateOffset
     videoFormats
     url
  }
}

QUERY VARIABLES

{
  "channelId": "123444",
  "profileId": "a123434",
  "channelPlaybackInput": {
      "streamFormat": "DASH",
      "videoFormats": [
        "H264"
      ],
      "audioFormats": [
        "AAC"
      ],
      "drm": "FAIRPLAY",
      "maxQuality": "HD",
      "abrNotSupported": false
    }
}
```

## Custom Types

### Scalar Types 
Pre kazdy z typov su aktualne implementovane 3 subory konkretny
 1) Typ ktory definuje typ doplnujuci schemu kniznice webonyx
 2) Mapper prevadza typ v inputoch, outputoch na konkretnu instanciu typu
 3) MapperFactory inicializuje mapper do containeru
 
- URL - viz App\Types\URL

- Milliseconds - viz App\Types\Milliseconds

### Enums
zalozene na libke  ```myclabs/php-enum```:
- Quality
 
- AudioFormat

- Drm

- Quality
 
- StreamFormat 

- VideoFormat


### ChannelPlaybackInput
odkaz https://graphqlite.thecodingmachine.io/docs/input-types
viz App\Types\Input\ChannelPlaybackInput


## Issues

- strankovanie 
    - je zalozene na kniznici beberlei/porpaginas, ktora z mojho pohladu nie je dlhodobo udrziavana 
    - paci sa mi ale jednoduchy koncept offset, limit na ktory si myslim by nemali clienti problem prejst
- exceptions 
    - nie je chyba samotneho balicku bude nutne riesit aj pri ApiPlatform a opat prekopnut ako vraciat spravny format

 
## Nice to have

- s touto kniznicou je mozne pouzit koncept dedenia a specializacie napriklad: 
```
contact {
    name
    ... User {
       email
    }
}
 ```   
(https://graphqlite.thecodingmachine.io/docs/inheritance-interfaces)