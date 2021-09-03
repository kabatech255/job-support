variable "domain_name" {
  type = string
  default = "kensa-system.net"
}

resource "aws_route53_zone" "default" {
  name = var.domain_name
}
