# NoSprint

[![Discord](https://img.shields.io/discord/830063409000087612?color=7389D8&label=discord)](https://discord.com/invite/EggNF9hvGv)
[![Poggit-CI](https://poggit.pmmp.io/ci.shield/AIPTU/NoSprint/NoSprint)](https://poggit.pmmp.io/ci/AIPTU/NoSprint/NoSprint)

A PocketMine-MP plugin to cancel the player's spint.

# Features

- Permissions bypass.
- Custom messages.
- Per world support.
- Lightweight and open source ❤️

# Config

```yaml
---
# Message to be used when canceling a player's sprint
# You can use "&" or "§" to color the message
message: "&cYou can't sprint in this world"

# The name of the world folder that you want to cancel the player's sprint
# Leave this blank if you don't want to cancel the player's sprint
blacklisted-worlds:
  - "world"
...
```

# Permissions

- Permission `nosprint.bypass` allows the user to bypass sprint.

# How to Install

1. Download the plugin from [here](https://poggit.pmmp.io/ci/AIPTU/NoSprint)
2. Put the `NoSprint.phar` file into the `plugins` folder.
3. Restart the server.
4. Done!

# Additional Notes

- If you find bugs or want to give suggestions, please visit [here](https://github.com/AIPTU/NoSprint/issues)
- Icons made from [www.flaticon.com](https://www.flaticon.com)

# License

```
MIT License

Copyright (c) 2021 AIPTU

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
