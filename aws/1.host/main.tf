variable "domain_name" {
  type = string
  default = "job-support.site"
}

resource "aws_route53_zone" "default" {
  name = var.domain_name
}
