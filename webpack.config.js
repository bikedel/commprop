let jsonLoader = require('json-loader');
loaders: [
  {
    include: /\.json$/,
    loaders: ['json-loader']
  }
]