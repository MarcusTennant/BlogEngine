# BlogEngine
This repo contains an extremely lightweight blogging engine, which was developed in prepreation for use in areas with slow data connections and limited data caps such as Eastern Africa.

In order to minimize data transfer to clients the engine preforms as much work as possible on the server. To this end the platform uses no javascript at all. All the while still supporting a modern design reminiscent of a typical heavyweight blogging engine, and a (relatively) responsive comment system.

Also included in this repository is a set of maintence files, allowing for an administrator to upload posts and check comments via SSH. If a user elects to not upload images, a full length blog post can be uploaded in less than 1Kb, the majority of which is the ascii text itself.

![screenshot](./example1.png)
![screenshot](./example2.png)
