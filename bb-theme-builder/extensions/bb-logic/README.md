This is a proof of concept / MVP plugin for work done around conditional logic and personalization in Beaver Builder, Gutenberg and possibly others.

Right now everything is being developed in this plugin but that should change in the future once this becomes a real feature / product.

For now, you'll see the following directories that could be split into their own plugins in the future...

- *core* - The core conditional logic UI that's built to be used _anywhere_.

- *editors* - Logic for implementing the conditional logic UI in different editors such as Beaver Builder and Gutenberg.

- *rest* - REST API logic that can be used by rules to populate their fields with data.

- *rules* - Conditional logic rules for different platforms such as WordPress, Google Analytics, Drip, and others. Each contains the registration of the rule for the UI and backend logic for processing the rule.

The short term goal of this project is to get a conditional logic system into Themer. The long term goal is to create a personalization product that uses third party data sources to customize content for individual users.

My favorite personalization example so far is using geolocation / weather data. With that you could show someone winter clothes on your ecommerce site if it's snowing where they are at and summer clothes if it's sunny. That's just one example, the possibilities with this kind of technology are endless!
