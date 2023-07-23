# NoSprint

[![](https://poggit.pmmp.io/shield.state/NoSprint)](https://poggit.pmmp.io/p/NoSprint)
[![](https://poggit.pmmp.io/shield.dl.total/NoSprint)](https://poggit.pmmp.io/p/NoSprint)

A PocketMine-MP plugin to cancel the player's spint.

# Features

- `Sprint Restriction`: Control player sprinting behavior in specific worlds.
- `None Mode`: Disable sprint restrictions, allowing unrestricted sprinting in all worlds.
- `Blacklist Mode`: Prevent players from sprinting in worlds listed in the blacklist.
- `Whitelist Mode`: Allow players to sprint only in worlds listed in the whitelist.
- `Customizable Message`: Display a custom message to players when they attempt to sprint in restricted worlds.
- `Permission Bypass`: Players with the `nosprint.bypass` permission can sprint freely in all worlds.
- `World Validation`: Ignore non-existent or ungenerated worlds listed in the configuration.
- `Configuration Management`: Automatically generate a new configuration if an outdated one is provided.
- `Event Handling`: Intercept player sprinting attempts and apply the appropriate restrictions based on the mode and configuration.

# Permissions

- `nosprint.bypass`: Allows users to bypass sprint.

# Default Config

```yaml
# Do not change this (Only for internal use)!
config-version: 1.3

# Message used when canceling a player's sprint.
# You can use color codes by using "§" or "&" before the color code.
message: "&cYou can't sprint in this world."

# World Restriction Settings
worlds:
  # The mode can be either "blacklist," "whitelist," or "none".
  # - "blacklist" mode will cancel player's sprint in the specified worlds (blacklisted) and allow sprinting in other worlds.
  # - "whitelist" mode will allow player's sprint only in the specified worlds (whitelisted) and cancel sprinting in other worlds.
  # - "none" mode will not apply any restriction, and sprinting will be allowed in all worlds.
  mode: "blacklist"

  # List of world folder names to be blacklisted or whitelisted (depending on the mode set above).
  # If "mode" is set to "blacklist" or "whitelist," add the world folder names accordingly.
  # If "mode" is set to "none," leave the "list" empty ([]) to allow sprinting in all worlds.
  list:
    - "world"  # Example: "world" world folder is blacklisted, and players can't sprint here.
    - "world_nether"  # Example: "world_nether" world folder is blacklisted, and players can't sprint here.

# You can add more worlds to the list as needed.
# Note: Make sure to use the correct world folder names as specified in your PocketMine-MP server configuration.
# To disable world-specific sprint restriction and allow sprinting in all worlds, set "mode" to "none" and leave the "list" empty ([]) or remove the "list" entirely.

```

# Upcoming Features

- Currently none planned. You can contribute or suggest for new features.

# Additional Notes

- If you find bugs or want to give suggestions, please visit [here](https://github.com/AIPTU/NoSprint/issues).
- We accept all contributions! If you want to contribute, please make a pull request in [here](https://github.com/AIPTU/NoSprint/pulls).
- Icons made from [www.flaticon.com](https://www.flaticon.com)
