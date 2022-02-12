# NoSprint

[![](https://poggit.pmmp.io/shield.state/NoSprint)](https://poggit.pmmp.io/p/NoSprint)
[![](https://poggit.pmmp.io/shield.dl.total/NoSprint)](https://poggit.pmmp.io/p/NoSprint)

A PocketMine-MP plugin to cancel the player's spint.

# Features

- Permission bypass.
- Custom messages.
- Per world support.
- Lightweight and open source ❤️

# Permissions

- Permission `nosprint.bypass` allows users to bypass sprint.

# Default Config

```yaml
---
# Do not change this (Only for internal use)!
config-version: 1.2

# Message used when canceling a player's sprint
# Use "§" or "&" to color the message
message: "&cYou can't sprint in this world"

worlds:
  # The mode can be either "blacklist" or "whitelist".
  # Blacklist mode will cancel player's sprint according to predefined world folder names and will not cancel player's sprint in all worlds.
  # Whitelist mode will only allow player's sprint according to predefined world folder names and will cancel player's sprint in all worlds.
  mode: "blacklist"
  # List of world folder names to blacklist/whitelist (depending on the mode set above).
  # Set it to [] if you want to allow sprint in all worlds.
  list:
    - "world"
...

```

# Upcoming Features

- Currently none planned. You can contribute or suggest for new features.

# Additional Notes

- If you find bugs or want to give suggestions, please visit [here](https://github.com/AIPTU/NoSprint/issues).
- We accept all contributions! If you want to contribute, please make a pull request in [here](https://github.com/AIPTU/NoSprint/pulls).
- Icons made from [www.flaticon.com](https://www.flaticon.com)
